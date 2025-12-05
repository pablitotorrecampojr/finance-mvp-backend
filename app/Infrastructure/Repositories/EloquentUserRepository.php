<?php
namespace App\Infrastructure\Repositories;

use App\Models\User;
use App\Domain\Repositories\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function resetPassword(int $userId, string $password): ?int
    {
        return User::where('id', $userId)->update([
            'password' => \Hash::make($password),
        ]);
    }
}
