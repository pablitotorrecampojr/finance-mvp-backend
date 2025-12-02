<?php
namespace App\Domain\Services;

use App\Domain\Repositories\IUserOTPRepository;;
use App\Models\User;
use App\Domain\Enums\AccountStatus;
use Carbon\Carbon;

class ResendOTPService
{
    private IUserOTPRepository $IuserOTPRespository;

    public function __construct(
        IUserOTPRepository $IuserOTPRespository
    )
    {
        $this->IuserOTPRespository = $IuserOTPRespository;
    }

    public function execute(int $userId)
    {
        $user = User::where('id', $userId)->first();
        $response = $this->IuserOTPRespository->send($user);
        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent!'
            ]);
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'Failed to send OTP!'
            ]);
        }
    }
}
