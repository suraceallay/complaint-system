<?php

namespace App\GraphQL\Queries;

use App\Models\Complaint;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;

class ComplaintQuery extends Query
{
    protected $attributes = [
        'name' => 'complaints',
        'description' => 'Get all complaints'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Complaint'));
    }

    public function resolve($root, $args)
    {
        // Check if user is authenticated
        if (!Auth::user()) {
            throw new \Exception('Unauthorized. Please login to view complaints.');
        }

        return Complaint::all();
    }
}