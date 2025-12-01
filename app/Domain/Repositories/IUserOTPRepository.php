<?php
namespace App\Domain\Repositories;

use App\Models\User;
use App\Models\UserOTP;

interface IUserOTPRepository
{
    public function send(User $user): void;
    public function findByUserId(int $userId);
}