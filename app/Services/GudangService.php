<?php

namespace App\Services;

use App\Http\Resources\GudangResource;
use App\Repositories\GudangRepository;
use Illuminate\Support\Collection;

class GudangService
{
    protected $repository;

    public function __construct(GudangRepository $repository)
    {
        $this->repository = $repository;
    }


    public function all($token): Collection
    {
        $response = $this->repository->getAll($token);

        if ($response->successful()) {
            return collect($response->json('data'))
                ->mapInto(GudangResource::class);
        }

        return collect();
    }

    public function find($id, $token): ?GudangResource
    {
        $response = $this->repository->getById($id, $token);

        if ($response->successful()) {
            return new GudangResource((object)$response->json('data'));
        }

        return null;
    }

    public function create(array $data, $token)
    {
        return $this->repository->store($data, $token);
    }

    public function edit($id, array $data, $token)
    {
        return $this->repository->update($id, $data, $token);
    }

    public function destroy($id, $token)
    {
        return $this->repository->delete($id, $token);
    }
}
