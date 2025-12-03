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
    public function send(User $user): ?UserOTP
    {
        try {
            $otp = rand(100000, 999999);
            $expires_at = Carbon::now()->addMinutes(1);
            $userOTP = \DB::transaction(function () use ($user, $otp, $expires_at) {
                UserOTP::where('user_id', $user->id)->delete();
                return UserOTP::create([
                    'user_id' => $user->id,
                    'value' => $otp,
                    'expires_at' => $expires_at,
                ]);
            });
            Mail::to($user->email)->send(new OTPMail($otp, $user->first_name));
            return $userOTP;
        } catch (\Throwable $th) {
            \Log::error('OTP send failed: '.$th->getMessage());
            return null;
        }
    }

    public function findByUserId(int $userId):?UserOTP
    {
        return UserOTP::where('user_id', $userId)
            ->latest()
            ->first();
    }
}