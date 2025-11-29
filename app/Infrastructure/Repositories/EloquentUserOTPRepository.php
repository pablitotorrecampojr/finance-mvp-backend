<?php
namespace App\Infrastructure\Repositories;
use App\Models\UserOTP;
use App\Models\User;
use App\Domain\Repositories\IUserOTPRepository;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;

class EloquentUserOTPRepository implements IUserOTPRepository
{
    public function send(User $user): void
    {
        $otp = rand(100000, 999999);
        Mail::to($user->email)->send(new OTPMail($otp, $user->first_name));
    }

    public function verify(int $user_id, string $value): bool
    {
        return true;
    }
}