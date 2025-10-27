<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AuthPayloadType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AuthPayload',
        'description' => 'Authentication payload type'
    ];

    public function fields(): array
    {
        return [
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Access Token',
            ],
            'token_type' => [
                'type' => Type::string(),
                'description' => 'Token Type',
                'defaultValue' => 'bearer',
            ],
            'expires_at' => [
                'type' => Type::string(),
                'description' => 'Token expiration date',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'Authenticated user',
            ],
        ];
    }
}