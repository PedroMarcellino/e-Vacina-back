<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByCpf(string $cpf): ?User
    {
        return User::where('cpf', $cpf)->first();
    }
}
