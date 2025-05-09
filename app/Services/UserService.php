<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

<<<<<<< HEAD
    public function count()
    {
        return $this->userRepository->count();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

=======
    public function count(){
        return $this->userRepository->count();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

>>>>>>> 23ddbcc59bd8065cca74042368d9fffb3695608c
    public function updateUser(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }
    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
