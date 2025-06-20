<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionRepository
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url') . '/transactions';
    }

    public function createTransaction(array $payload, $token): array
    {
        try {
            $response = Http::withToken($token)->post($this->baseUrl, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Terjadi kesalahan saat menyimpan transaksi.',
            ];
        } catch (\Exception $e) {
            Log::error('API CreateTransaction Error', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
            return [
                'success' => false,
                'message' => 'Gagal terhubung ke API transaksi.',
            ];
        }
    }

    public function find($id, $token)
    {
        try {
            $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

            return $response;
        } catch (\Exception $e) {
            Log::error('API FindTransaction Error', ['error' => $e->getMessage(), 'id' => $id]);
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data transaksi.'], 404);
        }
    }

    public function update($id, array $payload, $token): array
    {
        try {
            $response = Http::withToken($token)->put("{$this->baseUrl}/{$id}", $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data'),
                    'message' => $response->json('message'),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Gagal memperbarui transaksi.',
            ];
        } catch (\Exception $e) {
            Log::error('API UpdateTransaction Error', [
                'error' => $e->getMessage(),
                'payload' => $payload,
                'id' => $id
            ]);
            return [
                'success' => false,
                'message' => 'Gagal terhubung ke API untuk memperbarui transaksi.',
            ];
        }
    }

    public function getAll($token)
    {
        try {
            $response = Http::withToken($token)->get($this->baseUrl);
            return $response;
        } catch (\Exception $e) {
            Log::error('API GetAllTransactions Error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data transaksi.'], 500);
        }
    }

    public function checkAndParseBarang($token, string $kode)
    {
        try {
            $response = Http::withToken($token)->get("{$this->baseUrl}/check-barcode/{$kode}");

            if ($response->successful() && $response->json('success') === 'true') {
                return [
                    'success' => true,
                    'data' => $response->json('data'),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Barang tidak ditemukan.',
            ];
        } catch (\Exception $e) {
            Log::error('API CheckAndParseBarang Error', ['error' => $e->getMessage(), 'kode' => $kode]);
            return [
                'success' => false,
                'message' => 'Gagal memeriksa barang.',
            ];
        }
    }
}