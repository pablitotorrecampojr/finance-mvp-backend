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

    public function verify(int $userId, string $value)
    {
        $userOTP = UserOTP::where('user_id', $userId)
                        ->first();

        if (!$userOTP) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found!',
            ]);
        }

        if (Carbon::now()->greaterThan($userOTP->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired',
            ]);
        }

        if ($userOTP->value !== $value) {
             return response()->json([
                'success' => false,
                'message' => 'OTP doesn\'t match!',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully',
        ]);
    }
}