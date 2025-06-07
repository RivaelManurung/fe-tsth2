<?php

namespace App\Services;

use App\Repositories\BarangRepository;
use Illuminate\Support\Facades\Log;

class BarangService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new BarangRepository();
    }

    public function getAllBarang()
    {
        $token = session('token');
        return $this->repository->getAll($token);
    }

    public function countbarang(): int
    {
        $token = session('token');
        if (!$token) {
            Log::warning('No token found in BarangService::countbarang');
            return 0;
        }

        $barangs = $this->repository->getAll($token);
        if (is_null($barangs)) {
            Log::warning('Failed to fetch barangs, null returned', ['token' => substr($token, 0, 10) . '...']);
            return 0;
        }

        if (!is_array($barangs)) {
            Log::error('Invalid data type returned from repository', ['type' => gettype($barangs)]);
            return 0;
        }

        Log::info('Successfully counted barangs', ['count' => count($barangs)]);
        return count($barangs);
    }
    public function getBarangById($id)
    {
        $token = session('token');
        return $this->repository->getById($id, $token);
    }

    public function createBarang(array $data)
    {
        $token = session('token');
        return $this->repository->create($data, $token);
    }
    public function updateBarang($id, array $data)
    {
        $token = session('token');
        return $this->repository->update($id, $data, $token);
    }

    public function deleteBarang($id)
    {
        $token = session('token');
        return $this->repository->delete($id, $token);
    }
    public function regenerateQRCodeAll()
    {
        $token = session('token');
        return $this->repository->regenerateQRCodeAll($token);
    }

    public function exportQRCodePDF($id, $jumlah, $token)
    {
        return $this->repository->exportQRCodePDF($id, $jumlah, $token);
    }

    public function exportQRCodePDFAll($token)
    {
        return $this->repository->exportQRCodePDFAll($token);
    }
    public function getByKode($kode, $token)
    {
        $all = $this->repository->getAll($token);
        return collect($all)->firstWhere('barang_kode', $kode); // Mengambil barang berdasarkan kode
    }
}
