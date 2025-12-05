<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use App\Domain\Enums\ForgotPasswordCodes;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class ResetPasswordService
{
    private UserRepositoryInterface $userRepository;
    private IPasswordResetTokenRepository $passwordResetTokenRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IPasswordResetTokenRepository $passwordResetTokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordResetTokenRepository = $passwordResetTokenRepository;
    }

    public function execute(string $token, string $password)
    {
        $passwordResetToken = $this->passwordResetTokenRepository->findByToken($token);

        if (!$passwordResetToken) {
            return response()->json([
                'success' => false,
                'code' => ForgotPasswordCodes::INVALID,
                'message' => 'Reset token cannot be found!' 
            ]);
        }

        // if (Carbon::now()->greaterThan($passwordResetToken->expired_at)) {
        //     return response()->json([
        //         'success' => false,
        //         'code' => ForgotPasswordCodes::EXPIRED,
        //         'message' => 'Reset token has expired!'
        //     ]);
        // }

        $resetPassword = $this->userRepository->resetPassword($passwordResetToken->user_id, $password);
        
        if (!$resetPassword) {
            return response()->json([
                'success' => false,
                'code' => ForgotPasswordCodes::FAILED,
                'message' => 'Failed to reset user password!'
            ]);
        }

        $passwordResetToken->delete();

        return response()->json([
            'success' => true,
            'code' => ForgotPasswordCodes::SUCCESS,
            'message' => 'Reset password was a success!'
        ]);
    }
}
