<?php

namespace App\GraphQL\Mutations;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateComplaintMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createComplaint',
        'description' => 'Create a complaint'
    ];

    public function type(): Type
    {
        return GraphQL::type('Complaint');
    }

    public function args(): array
    {
        return [
            'complain' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The complaint text',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Complaint::create([
            'complain' => $args['complain'],
        ]);
    }
}