<?php
namespace App\Domain\Repositories;

use App\Models\User;
use App\Models\UserOTP;

interface IUserOTPRepository
{
    public function send(User $user): ?UserOTP;
    public function findByUserId(int $userId);
    public function resetPassword(int $userId, string $password):?User;
}