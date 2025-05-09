<?php
<<<<<<< HEAD
=======

>>>>>>> 23ddbcc59bd8065cca74042368d9fffb3695608c
namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class WebRepositories
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/webs';
    }

<<<<<<< HEAD
    public function getAll($token)
    {
        return Http::withToken($token)->get($this->baseUrl)->json('data');
    }

    public function update($token, $id, $data)
    {
        return Http::withToken($token)->put("{$this->baseUrl}/{$id}", $data)->json();
=======
    // Mengambil semua data dari API
    public function getById($token, $id = 1)
    {
        $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            return $response->json('data'); // atau 'data' kalau API-nya nested
        } else {
            return null;
        }
    }

    // Metode update data
    public function update($token, $id, $data)
    {
        $response = Http::withToken($token)->put("{$this->baseUrl}/{$id}", $data);

        if ($response->successful()) {
            return $response->json();
        } else {
            // Log error atau return null jika gagal
            return null;
        }
>>>>>>> 23ddbcc59bd8065cca74042368d9fffb3695608c
    }
}
