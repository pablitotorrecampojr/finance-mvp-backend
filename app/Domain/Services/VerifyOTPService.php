<?php
namespace App\Domain\Services;

use App\Domain\Repositories\IUserOTPRepository;;
use App\Models\User;
use App\Domain\Enums\AccountStatus;
use App\Domain\Enums\OTPResponseCodes;
use Carbon\Carbon;

class VerifyOTPService
{
    private IUserOTPRepository $IuserOTPRespository;

    public function __construct(
        IUserOTPRepository $IuserOTPRespository
    )
    {
        $this->IuserOTPRespository = $IuserOTPRespository;
    }

    public function execute(int $userId, string $value)
    {
        $userOTP = $this->IuserOTPRespository->findByUserId($userId);
        if(!$userOTP) {
            return response()->json([
                'success' => false,
                'code' => OTPResponseCodes::NOTFOUND,
                'message' => 'OTP not found.',
            ], 404);
        }

        if(Carbon::now()->greaterThan($userOTP->expires_at)) {
            return response()->json([
                'success' => false,
                'code' => OTPResponseCodes::EXPIRED,
                'message' => 'OTP has expired.',
            ], 400);
        }

        if($userOTP->value !== $value) {
            return response()->json([
                'success' => false,
                'code' => OTPResponseCodes::MISMATCH,
                'message' => 'OTP mismatch.',
            ], 400);
        }

        \DB::transaction(function () use ($userId, $userOTP) {
            $user = User::find($userId);
            $user->update([
                'email_verified_at' => Carbon::now(),
                'status' => AccountStatus::ACTIVE,
            ]);
            $userOTP->delete();
        });

        return response()->json([
            'success' => true,
            'code' => OTPResponseCodes::SUCCESS,
            'message' => 'OTP verified successfully.',
        ]);
    }
}
