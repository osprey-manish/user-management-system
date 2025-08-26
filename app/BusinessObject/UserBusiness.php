<?php

namespace App\BusinessObject;

use App\DataAccessObject\UserDao;
use Illuminate\Support\Facades\Hash;

class UserBusiness
{
    protected UserDao $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    public function createNewUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userDao->create($data);
    }

    public function updateUser($user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userDao->update($user, $data);
    }
}
