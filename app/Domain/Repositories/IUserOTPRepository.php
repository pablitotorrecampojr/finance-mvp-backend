<?php
namespace App\Domain\IUserOTPRepository;
use App\Models\UserOTP;
use App\Models\User;

interface IUserOTPRepository
{
    public function send(User $user): void;
    public function verify(int $userId, string $otp): bool;
}