<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the user',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The user ID',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of user',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The created date of the user',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The updated date of the user',
            ],
        ];
    }
}