<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'loginUser',
        'description' => 'Login a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('AuthPayload');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'User ID',
                'rules' => ['required', 'string'],
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password',
                'rules' => ['required', 'string'],
            ],
            'remember_me' => [
                'type' => Type::boolean(),
                'description' => 'Remember me',
                'defaultValue' => false,
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::where('user_id', $args['user_id'])->first();

        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        // Create token with expiry
        $token = $user->createAuthToken();

        // Login user for session (optional)
        Auth::login($user, $args['remember_me'] ?? false);

        return [
            'token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'expires_at' => $token->accessToken->expires_at,
            'user' => $user,
        ];
    }
}