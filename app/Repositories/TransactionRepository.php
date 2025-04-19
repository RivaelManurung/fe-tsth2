<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class TransactionRepository
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/transactions'; // Mendapatkan URL base untuk API transaksi
    }

    // Mengambil semua transaksi
    public function getAll($token)
    {
        return Http::withToken($token)->get($this->baseUrl); // Menggunakan HTTP client Laravel dengan token untuk mengambil data transaksi
    }

    public function checkBarcode($token, string $kode)
    {
        return Http::withToken($token)->get("{$this->baseUrl}/check-barcode/{$kode}");
    }

}
