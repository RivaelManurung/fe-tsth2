<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getAllTransactions($token): Collection
    {
        $response = $this->transactionRepository->getAll($token);

        if ($response->successful()) {
            return collect($response->json('data'));
        }

        return collect();
    }

    public function checkAndAddBarang(string $kode, string $token, Session $session): ?array
    {
        $response = $this->transactionRepository->checkBarcode($token, $kode);

        if ($response->successful() && $response->json('success')) {
            $barang = $response->json('data');
            $daftarBarang = $session->get('daftar_barang', []);

            if (isset($daftarBarang[$barang['barang_kode']])) {
                $daftarBarang[$barang['barang_kode']]['jumlah'] += 1;
            } else {
                $daftarBarang[$barang['barang_kode']] = [
                    'nama' => $barang['barang_nama'],
                    'kode' => $barang['barang_kode'],
                    'jumlah' => 1,
                    'stok_tersedia' => $barang['stok_tersedia'],
                    'gambar' => $barang['gambar'],
                ];
            }

            $session->put('daftar_barang', $daftarBarang);

            return $daftarBarang;
        }

        return null;
    }
    public function storeTransaction(string $tipe, array $daftarBarang, string $token)
    {
        $payload = [
            'transaction_type_id' => $tipe,
            'items' => array_map(fn($item) => [
                'barang_kode' => $item['kode'],
                'quantity'    => $item['jumlah'],
            ], $daftarBarang),
        ];

        return $this->transactionRepository->storeTransaction($token, $payload);
    }
}

