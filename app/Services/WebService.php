<?php

namespace App\Services;

use App\Repositories\WebRepositories;

class WebService
{
    protected $webRepo;

    public function __construct(WebRepositories $webRepo)
    {
        $this->webRepo = $webRepo;
    }

    public function getAll($token)
    {
        return $this->webRepo->getAll($token);
    }

    public function update($token, $id, $data)
    {
        return $this->  webRepo->update($token, $id, $data);
    }
}
