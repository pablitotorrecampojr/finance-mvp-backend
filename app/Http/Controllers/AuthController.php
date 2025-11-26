<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\RegisterUserService;
use App\Domain\Services\LoginUserService;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{
    private RegisterUserService $registerUserService;
    private LoginUserService $loginUserService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService $loginUserService
    ) {
        $this->registerUserService = $registerUserService;
        $this->loginUserService = $loginUserService;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->registerUserService->execute($data);
        return response()->json($user, 201);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();

        $token = $this->loginUserService->execute($data['email'], $data['password']);
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }
}
