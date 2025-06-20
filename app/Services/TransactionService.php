<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getAllTransactions($token): Collection
    {
        try {
            $response = $this->transactionRepository->getAll($token);

            if ($response->successful()) {
                return collect($response->json('data'));
            }

            Log::warning('Failed to fetch transactions', ['status' => $response->status()]);
            return collect();
        } catch (Exception $e) {
            Log::error('Error fetching transactions', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    public function find($id, $token): array
    {
        try {
            $response = $this->transactionRepository->find($id, $token);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data'),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Transaksi tidak ditemukan.',
            ];
        } catch (Exception $e) {
            Log::error('API FindTransaction Error', ['error' => $e->getMessage(), 'id' => $id]);
            return [
                'success' => false,
                'message' => 'Gagal mengambil data transaksi.',
            ];
        }
    }

    public function store(array $data, $token): array
    {
        try {
            if (!isset($data['transaction_type_id']) || !is_array($data['items'])) {
                throw new \InvalidArgumentException("Data transaksi tidak lengkap.");
            }

            $data['items'] = array_map(function ($item) {
                return [
                    'barang_kode' => $item['kode'],
                    'quantity' => $item['jumlah'],
                    'description' => $item['description'] ?? null,
                    'barang_nama' => $item['nama'] ?? null,
                    'satuan_id' => $item['satuan_id'] ?? null,
                ];
            }, array_values($data['items']));

            $response = $this->transactionRepository->createTransaction($data, $token);

            if (!$response['success']) {
                throw new \Exception($response['message']);
            }

            return ['success' => true, 'message' => 'Transaksi berhasil disimpan'];
        } catch (Exception $e) {
            Log::error('Gagal menyimpan transaksi', [
                'error' => $e->getMessage(),
                'payload' => $data
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function update($id, array $data, $token): array
    {
        try {
            if (!isset($data['transaction_type_id']) || !isset($data['transaction_date']) || !isset($data['user_id']) || !is_array($data['items'])) {
                throw new \InvalidArgumentException("Data transaksi tidak lengkap.");
            }

            $data['items'] = array_map(function ($item) {
                return [
                    'barang_kode' => $item['kode'],
                    'quantity' => $item['jumlah'],
                    'description' => $item['description'] ?? null,
                    'barang_nama' => $item['nama'] ?? null,
                    'satuan_id' => $item['satuan_id'] ?? null,
                ];
            }, array_values($data['items']));

            Log::info('Sending update request to repository', ['id' => $id, 'data' => $data]);
            $response = $this->transactionRepository->update($id, $data, $token);
            Log::info('Update response from repository', ['response' => $response]);

            if (!$response['success']) {
                throw new \Exception($response['message'] ?? 'Gagal memperbarui transaksi.');
            }

            return [
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui',
                'data' => $response['data']
            ];
        } catch (Exception $e) {
            Log::error('Gagal memperbarui transaksi', [
                'error' => $e->getMessage(),
                'payload' => $data,
                'id' => $id
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    // Commented out unused methods
    /*
    public function checkAndAddBarang($token, string $kode, array $currentItems): array
    {
        // ... (previous checkAndAddBarang code)
    }

    public function resetDaftarBarang(): array
    {
        // ... (previous resetDaftarBarang code)
    }

    public function removeBarang(string $kode, array $currentItems): array
    {
        // ... (previous removeBarang code)
    }
    */
}