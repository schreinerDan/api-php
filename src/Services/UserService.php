<?php
namespace Services;

use Repositories\UserRepository;
use Models\User;

class UserService 
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers()
    {
        return $this->repository->getAll();
    }

    public function getUserById($id)
    {
        return $this->repository->getById($id);
    }

    public function getUserByUsername($name)
    {
        return $this->repository->getUserByUsername($name);
    }

    public function createUser(User $user)
    {
        return $this->repository->createUser($user);
    }

    public function updateUser($id, User $user)
    {
        return $this->repository->updateUser($id, $user);
    }

    public function deleteUser($id)
    {
        return $this->repository->delete($id);
    }
}
