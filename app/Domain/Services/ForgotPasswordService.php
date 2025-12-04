<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use App\Domain\Enums\ForgotPasswordCodes;
use App\Models\PasswordResetToken;

class ForgotPasswordService
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

    public function execute(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return response()->json([
                'success'=> false,
                'code' => ForgotPasswordCodes::MISMATCH,
                'message' => "No account with that email found!"
            ]);
        }

        $token = \Str::random(64);
        $passwordResetToken = $this->passwordResetTokenRepository->create($user->email, $token);
        
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'data'    => [
                'user'  => new UserResource($user),
            ],
        ]);
    }
}
