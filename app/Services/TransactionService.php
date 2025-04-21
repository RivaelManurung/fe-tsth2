<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Support\Collection;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    // Mendapatkan semua transaksi
    public function getAllTransactions($token): Collection
    {
        $response = $this->transactionRepository->getAll($token);

        if ($response->successful()) {
            return collect($response->json('data'));
        }

        return collect();
    }

    public function checkBarcode($token, string $kode)
    {
        return $this->transactionRepository->checkBarcode($token, $kode);
    }

    public function checkAndAddBarang($token, string $kode, array $currentItems): array
    {
        $result = $this->transactionRepository->checkAndParseBarang($token, $kode);

        if (!$result['success']) {
            return [
                'success' => true,
                'message' => $result['message']
            ];
        }

        $barang = $result['data'];

        $barang['stok_tersedia'] = $barang['stok_tersedia'];
        $barang['gambar'] = $barang['gambar'];

        if (isset($currentItems[$barang['barang_kode']])) {
            $currentItems[$barang['barang_kode']]['jumlah'] += 1;
        } else {
            $currentItems[$barang['barang_kode']] = [
                'nama' => $barang['barang_nama'],
                'kode' => $barang['barang_kode'],
                'jumlah' => 1,
                'stok_tersedia' => $barang['stok_tersedia'],
                'gambar' => $barang['gambar'],
            ];
        }

        return [
            'success' => true,
            'data' => $currentItems,
        ];
    }

    public function resetDaftarBarang(): array
    {
        return [];
    }

    public function removeBarang(string $kode, array $currentItems): array
    {
        if (isset($currentItems[$kode])) {
            unset($currentItems[$kode]);

            return [
                'success' => true,
                'data' => $currentItems,
                'message' => 'Barang berhasil dihapus.',
            ];
        }

        return [
            'success' => false,
            'data' => $currentItems,
            'message' => 'Barang tidak ditemukan.',
        ];
    }
}
