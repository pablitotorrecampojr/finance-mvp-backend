<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Services\RegisterUserService;
use App\Application\Services\LoginUserService;

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

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->registerUserService->execute($data);
        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $token = $this->loginUserService->execute($data['email'], $data['password']);
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }
}
