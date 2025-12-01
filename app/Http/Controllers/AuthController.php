<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\RegisterUserService;
use App\Domain\Services\LoginUserService;
use App\Domain\Services\VerifyOTPService;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Http\Requests\SendAnotherOTPRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private RegisterUserService $registerUserService;
    private LoginUserService $loginUserService;
    private VerifyOTPService $verifyOTPService;
    private SendAnotherOTPRequest $sendAnotherOTPService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService $loginUserService,
        VerifyOTPService $verifyOTPService,
        SendAnotherOTPRequest $sendAnotherOTPService
    ) {
        $this->registerUserService = $registerUserService;
        $this->loginUserService = $loginUserService;
        $this->verifyOTPService = $verifyOTPService;
        $this->sendAnotherOTPService = $sendAnotherOTPService;
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

    public function sendAnotherOTP(SendAnotherOTPRequest $request) 
    {
        $data = $request->validated();
        $response = $this->sendAnotherOTPService->execute($data['user_id']);
        return $response;
    }
}
