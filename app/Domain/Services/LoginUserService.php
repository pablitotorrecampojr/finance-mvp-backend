<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): ?string
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        // Generate a simple token (e.g., using Laravel Sanctum or JWT)
        return $user->createToken('auth_token')->plainTextToken;
    }
}
