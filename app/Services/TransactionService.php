<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class TransactionService
{
    protected $transactionRepository; // Properti untuk repository

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository; // Injeksi dependensi repository
    }

    // Mendapatkan semua transaksi
    public function getAllTransactions($token): Collection
    {
        $response = $this->transactionRepository->getAll($token); // Memanggil repository untuk mendapatkan data transaksi

        if ($response->successful()) {
            return collect($response->json('data')); // Jika berhasil, kembalikan data transaksi
        }

        return collect(); // Jika gagal, kembalikan collection kosong
    }

    public function checkBarcode($token, string $kode)
    {
        return $this->transactionRepository->checkBarcode($token, $kode);
    }


}
