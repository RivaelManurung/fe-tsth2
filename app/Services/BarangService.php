<?php

namespace App\Services;

use App\Repositories\BarangRepository;

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
        $response = $this->repository->update($id, $data, $token);
        logger()->info('Update Barang Response:', $response);
        return $response;
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

}
