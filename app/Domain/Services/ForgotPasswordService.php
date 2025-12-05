<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use App\Domain\Enums\ForgotPasswordCodes;
use App\Models\PasswordResetToken;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

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
        $passwordResetToken = $this->passwordResetTokenRepository->create($user->id, $user->email, $token);
        if (!$passwordResetToken) {
            return response()->json([
                'success'=> false,
                'code' => ForgotPasswordCodes::FAILED,
                'message' => "Failed to create send to email."
            ]);
        }

        $domain = config('sanctum.stateful')[0];
        $resetLink = "http://{$domain}/reset-password?token={$token}";

        Mail::to($user->email)->send(new ForgotPasswordMail($resetLink, $user->first_name));

        return response()->json([
            'success' => true,
            'code' => ForgotPasswordCodes::SUCCESS,
            'message' => "Reset password link was sent to provide email!"
        ]);
    }
}
