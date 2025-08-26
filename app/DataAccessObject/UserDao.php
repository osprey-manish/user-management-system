<?php

namespace App\DataAccessObject;

use App\Models\User;

class UserDao
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findAll()
    {
        return User::all();
    }
}
