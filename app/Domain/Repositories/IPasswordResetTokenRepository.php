<?php
namespace App\Domain\Repositories;

use App\Models\PasswordResetToken;

interface IPasswordResetTokenRepository
{
    public function create(string $email, string $token) :?PasswordResetToken;
    public function findByToken(string $token): ?PasswordResetToken;
}