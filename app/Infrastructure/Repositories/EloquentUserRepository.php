<?php
namespace App\Infrastructure\Repositories;

use App\Model\User;
use App\Domain\Repositories\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
