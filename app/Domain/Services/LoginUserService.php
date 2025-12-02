<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class LoginUserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data' => [
                    'email' => 'Email not found!',
                    'password' => 'Invalid password!'
                ]
            ], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify email before continuing.',
                'data' => [
                    'email' => 'Email not verified!',
                    'passowrd' => 'Invalid password!'
                ]
            ], 401);
        }
        $token = $user->createToken($email.'_token')->plainTextToken;

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
