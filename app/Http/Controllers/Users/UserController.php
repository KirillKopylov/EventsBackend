<?php


namespace App\Http\Controllers\Users;


use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Services\Users\UserService;

class UserController
{
    private $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function createUser(CreateUserRequest $request)
    {
        return $this->userService->createUser($request->validated());
    }

    public function removeUser(int $id)
    {
        return $this->userService->removeUser($id);
    }

    public function getUser(int $id)
    {
        return $this->userService->getUser($id);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        return $this->userService->updateUser($request->validated());
    }

    public function getUsers()
    {
        return $this->userService->getUsers();
    }
}
