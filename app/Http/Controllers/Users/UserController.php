<?php


namespace App\Http\Controllers\Users;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;

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

    public function removeUser($id)
    {
        return $this->userService->removeUser($id);
    }

    public function getUser($id)
    {
        return $this->userService->getUser($id);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        return $this->userService->updateUser($request->validated());
    }
}
