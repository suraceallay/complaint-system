<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Rebing\GraphQL\Support\Facades\GraphQL;

class LogoutUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logoutUser',
        'description' => 'Logout a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('Logout');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, $args, $context)
    {
        $user = $context->getUser();

        if (!$user) {
            throw new \Exception('Not authenticated');
        }

        // Revoke current token
        $token = $context->getToken();
        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $accessToken->delete();
            }
        }

        // Alternative: Revoke all tokens
        // $user->tokens()->delete();

        // Logout the user
        Auth::logout();

        return [
            'success' => true,
            'message' => 'Logged out successfully',
        ];
    }
}