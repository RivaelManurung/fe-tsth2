<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class TransactionRepository
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/transactions';
    }

    // Mengambil semua transaksi
    public function getAll($token)
    {
        return Http::withToken($token)->get($this->baseUrl);
    }

    public function checkBarcode($token, string $kode)
    {
        return Http::withToken($token)->get("{$this->baseUrl}/check-barcode/{$kode}");
    }

    public function storeTransaction(string $token, array $payload)
    {
        return Http::withToken($token)->post($this->baseUrl, $payload);
    }
}
