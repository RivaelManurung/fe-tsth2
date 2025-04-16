<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class BarangRepository
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/barangs';
    }

    public function getAll($token)
    {
        return Http::withToken($token)->get($this->baseUrl)->json('data');
    }

    public function getById($id, $token)
    {
        return Http::withToken($token)->get("{$this->baseUrl}/{$id}")->json('data');
    }

    public function create(array $data, $token)
    {
        return Http::withToken($token)->post($this->baseUrl, $data)->json();
    }


    public function update($id, array $data, $token)
    {
        $response = Http::withToken($token)
            ->put("{$this->baseUrl}/{$id}", $data);

        logger()->info('Payload update:', $data);
        logger()->info('Response update:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'status' => $response->status(),
            'message' => $response->body()
        ];
    }


    public function delete($id, $token)
    {
        return Http::withToken($token)->delete("{$this->baseUrl}/{$id}")->json();
    }

    public function regenerateQRCodeAll($token)
    {
        $url = config('api.base_url') . '/generate-qrcodes';
        $response = Http::withToken($token)->get($url);

        logger()->info('QR Refresh Response:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        return $response->json();
    }
}
