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

<<<<<<< HEAD
    public function getAll($token)
    {
        return $this->webRepo->getAll($token);
=======
    public function getById($token, $id = 1)
    {
        return $this->webRepo->getById($token, $id);
>>>>>>> 23ddbcc59bd8065cca74042368d9fffb3695608c
    }

    public function update($token, $id, $data)
    {
        return $this->  webRepo->update($token, $id, $data);
    }
}
