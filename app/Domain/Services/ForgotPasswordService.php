<?php
namespace App\Domain\Services;

use App\Domain\Repositories\IForgotPasswordRespository;

class ForgotPasswordService
{
    private IForgotPasswordRespository $forgotPasswordRepository;

    public function __construct(IForgotPasswordRespository $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

    public function execute(string $email)
    {
        $user = $this->forgotPasswordRepository->send($email);
        
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
