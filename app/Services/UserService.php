<?php

namespace App\Services;

use App\BusinessObject\UserBusiness;
use App\DataAccessObject\UserDao;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected UserBusiness $UserBusiness;
    protected UserDao $userDao;

    public function __construct(UserBusiness $UserBusiness, UserDao $userDao)
    {
        $this->UserBusiness = $UserBusiness;
        $this->userDao = $userDao;
    }

    public function getUserById(int $id)
    {
        return Cache::remember("user:{$id}", 3600, function () use ($id) {
            return $this->userDao->findById($id);
        });
    }

    public function getAllUsers()
    {
        return Cache::remember("users:all", 3600, function () {
            return $this->userDao->findAll();
        });
    }

    public function createNewUser(array $data)
    {
        $user = $this->UserBusiness->createNewUser($data);
        Cache::forget("users:all");
        Cache::put("user:{$user->id}", $user, 3600);
        return $user;
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->userDao->findById($id);
        if (!$user) {
            return null;
        }
        $updated = $this->UserBusiness->updateUser($user, $data);
        Cache::forget("users:all");
        Cache::forget("user:{$id}");
        Cache::put("user:{$id}", $updated, 3600);
        return $updated;
    }
}
