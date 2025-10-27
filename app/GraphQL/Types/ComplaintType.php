<?php

namespace App\GraphQL\Types;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ComplaintType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Complaint',
        'description' => 'A complaint',
        'model' => Complaint::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the complaint',
            ],
            'complain' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The complaint text',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date',
            ],
        ];
    }
}