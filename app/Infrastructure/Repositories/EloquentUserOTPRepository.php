<?php
namespace App\Infrastructure\Repositories;
use App\Models\UserOTP;
use App\Models\User;
use App\Domain\Repositories\IUserOTPRepository;

class EloquentUserOTPRepository implements IUserOTPRepository
{
    public function send(User $user): void
    {
        
    }

    public function verify(int $user_id, string $value): bool
    {
        return true;
    }
}