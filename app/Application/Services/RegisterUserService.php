<?php
namespace App\Application\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;

class RegisterUserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
