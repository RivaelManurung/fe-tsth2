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
        $hasFile = isset($data['barang_gambar']) && $data['barang_gambar'] instanceof \Illuminate\Http\UploadedFile;

        $request = Http::withToken($token)->asMultipart();
        $payload = collect($data)->map(function ($value, $key) {
            return is_array($value) ? json_encode($value) : $value;
        })->toArray();

        if (!$hasFile) {
            unset($payload['barang_gambar']);
        }
        logger()->info('Payload update:', $payload);

        $payload['_method'] = 'PUT';

        return $request
            ->post("{$this->baseUrl}/{$id}", $payload)
            ->json();
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

