<?php

namespace App\GraphQL;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Context
{
    public $user;
    public $token;
    public $request;

    public function __construct(array $params = [])
    {
        $this->request = $params['request'] ?? null;
        $this->user = $this->request ? $this->request->user() : null;
        $this->token = $this->request ? $this->request->bearerToken() : null;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function isAuthenticated()
    {
        return !is_null($this->user);
    }
}