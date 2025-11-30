<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\RegisterUserService;
use App\Domain\Services\LoginUserService;
use App\Domain\Services\UserOTPService;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private RegisterUserService $registerUserService;
    private LoginUserService $loginUserService;
    private UserOTPService $userOTPService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService $loginUserService,
        UserOTPService $userOTPService
    ) {
        $this->registerUserService = $registerUserService;
        $this->loginUserService = $loginUserService;
        $this->userOTPService = $userOTPService;
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

        $token = $this->loginUserService->execute($data['email'], $data['password']);
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return $token;
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        $data = $request->validated();
        $response = $this->userOTPService->execute($data['user_id'], $data['value']);
        return $response;
    }
}
