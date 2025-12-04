<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Enums\ForgotPasswordCodes;

class ForgotPasswordService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
