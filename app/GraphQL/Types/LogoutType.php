<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LogoutType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Logout',
        'description' => 'Logout type'
    ];

    public function fields(): array
    {
        return [
            'success' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Whether logout was successful',
            ],
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Logout message',
            ],
        ];
    }
}