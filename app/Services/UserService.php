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

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

<<<<<<< HEAD
    public function updateUser(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
=======
    public function getuserbyid($id)
    {
        return $this->withToken()->get("{$this->apiBaseUrl}/users/{$id}");
>>>>>>> bf198d4516aa8169c1efc5b219024782583fc4bc
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
