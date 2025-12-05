<?php
namespace App\Infrastructure\Repositories;
use App\Models\PasswordResetToken;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use Carbon\Carbon;

class EloquentPasswordResetTokenRepository implements IPasswordResetTokenRepository
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

    public function findByToken(string $token): ?PasswordResetToken
    {
        return PasswordResetToken::where([
            'token' => $token
        ])->first();
    }
}