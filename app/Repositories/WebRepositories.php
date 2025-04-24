<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class WebRepositories
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/webs';
    }

    public function getAll($token)
    {
        return Http::withToken($token)->get($this->baseUrl)->json('data');
    }

    public function update($token, $id, $data)
    {
        return Http::withToken($token)->put("{$this->baseUrl}/{$id}", $data)->json();
    }
}
