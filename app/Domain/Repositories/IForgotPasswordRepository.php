<?php
namespace App\Domain\Repositories;

use App\Models\User;
use App\Models\UserOTP;

interface IForgotPasswordRepository
{
    public function send(User $user): void;
    
}