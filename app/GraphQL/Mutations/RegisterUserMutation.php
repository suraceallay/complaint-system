<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'registerUser',
        'description' => 'Register a new user'
    ];

    public function type(): Type
    {
        return GraphQL::type('AuthPayload');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the user',
                'rules' => ['required', 'string', 'max:255'],
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of the user',
                'rules' => ['required', 'email', 'unique:users,email'],
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password of the user',
                'rules' => ['required'],
            ],
            'confirm_password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password confirmation',
                'rules' => ['required', 'same:password'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        // Generate unique user_id
        do {
            $code = random_int(100000, 999999);
        } while (User::where('user_id', $code)->exists());

        $user = User::create([
            'user_id' => (string)$code,
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);

        // Auto-login after registration
        $token = $user->createAuthToken();
        Auth::login($user);

        return [
            'token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'expires_at' => $token->accessToken->expires_at,
            'user' => $user,
        ];
    }
}