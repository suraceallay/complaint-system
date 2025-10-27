<?php

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;

class MyProfileQuery extends Query
{
    protected $attributes = [
        'name' => 'profile',
        'description' => 'Get authenticated user profile'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [];
    }

    public function authorize($root, array $args, $context, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        // Check if user is authenticated via context
        return !is_null($context->getUser());
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = $context->getUser();

        if (!$user) {
            throw new \Exception('Not authenticated');
        }

        return $user;
    }
}