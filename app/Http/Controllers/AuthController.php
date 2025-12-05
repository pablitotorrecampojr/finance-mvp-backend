<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\RegisterUserService;
use App\Domain\Services\LoginUserService;
use App\Domain\Services\VerifyOTPService;
use App\Domain\Services\ResendOTPService;
use App\Domain\Services\ForgotPasswordService;
use App\Domain\Services\ResetPasswordService;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Http\Requests\ResendOTPRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private RegisterUserService $registerUserService;
    private LoginUserService $loginUserService;
    private VerifyOTPService $verifyOTPService;
    private ResendOTPService $resendOTPService;
    private ForgotPasswordService $forgotPasswordService;
    private ResetPasswordService $resetPasswordService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService $loginUserService,
        VerifyOTPService $verifyOTPService,
        ResendOTPService $resendOTPService,
        ForgotPasswordService $forgotPasswordService,
        ResetPasswordService $resetPasswordService
    ) {
        $this->registerUserService = $registerUserService;
        $this->loginUserService = $loginUserService;
        $this->verifyOTPService = $verifyOTPService;
        $this->resendOTPService = $resendOTPService;
        $this->forgotPasswordService = $forgotPasswordService;
        $this->resetPasswordService = $resetPasswordService;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->registerUserService->execute($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user'=> new UserResource($user),
            'token'=>$token
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();

        $response = $this->loginUserService->execute($data['email'], $data['password']);
        if (!$response) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return $response;
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        $data = $request->validated();
        $response = $this->verifyOTPService->execute($data['user_id'], $data['value']);
        return $response;
    }

    public function resendOTP(ResendOTPRequest $request) 
    {
        $data = $request->validated();
        $response = $this->resendOTPService->execute($data['id']);
        return $response;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $request->validated();
        $response = $this->forgotPasswordService->execute($data['email']);
        return $response;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $response = $this->resetPasswordService->execute($data['token'], $data['password']);
        return $response;
    }
}
