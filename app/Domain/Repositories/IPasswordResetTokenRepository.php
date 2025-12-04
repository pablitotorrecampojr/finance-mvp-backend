<?php
namespace App\Domains\Repositories;

use App\Models\PasswordResetToken;

interface IPasswordResetTokenRepository
{
    public function create(string $email, string $token) :PasswordResetToken;
}