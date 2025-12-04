<?php
namespace App\Infrastructure\Repositories;
use App\Models\PasswordResetToken;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use Carbon\Carbon;

class elPasswordResetTokenRepository implements IPasswordResetTokenRepository
{
    public function create(string $email, string $token): ?PasswordResetToken
    {
        return PasswordResetToken::create([
            'email' => $email,
            'token' => $token,
            'expired_at' => Carbon::now()->addMinutes(10),
            'created_at' => Carbon::now()
        ]);
    }
}