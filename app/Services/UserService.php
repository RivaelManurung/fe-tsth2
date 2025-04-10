<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserService
{
    protected $apiBaseUrl;
    protected $token;

    public function __construct()
    {
        $this->apiBaseUrl = config('api.base_url');
        $this->token = session('token');
    }

    protected function withToken()
    {
        return Http::withToken($this->token);
    }

    public function getRoles()
{
    return $this->withToken()->get("{$this->apiBaseUrl}/roles");
}

    public function getAllUsers()
    {
        return $this->withToken()->get("{$this->apiBaseUrl}/users");
    }

    public function createUser($data)
    {
        return $this->withToken()->post("{$this->apiBaseUrl}/users", $data);
    }

    public function getUser($id)
    {
        return $this->withToken()->get("{$this->apiBaseUrl}/users/{$id}");
    }


    public function deleteUser($id)
    {
        return $this->withToken()->delete("{$this->apiBaseUrl}/users/{$id}");
    }
}
