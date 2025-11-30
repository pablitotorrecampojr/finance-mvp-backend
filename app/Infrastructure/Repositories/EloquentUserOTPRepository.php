<?php
namespace App\Infrastructure\Repositories;
use App\Models\UserOTP;
use App\Models\User;
use App\Domain\Repositories\IUserOTPRepository;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EloquentUserOTPRepository implements IUserOTPRepository
{
    public function send(User $user): void
    {
        $otp = rand(100000, 999999);
        $expires_at = Carbon::now()->addMinutes(5);
        UserOTP::create([
            'user_id' => $user->id,
            'value'=> $otp,
            'expires_at'=> $expires_at
        ]);
        Mail::to($user->email)->send(new OTPMail($otp, $user->first_name));
    }

    public function verify(int $userId, string $value): bool
    {
        $userOTP = UserOTP::where([
            'user_id' => $userId,
            'value' => $value
        ])->first();
        if (!$userOTP) {
            return false;
        }
        return Carbon::now()->lessThanOrEqualTo($userOTP->expires_at);
    }
}