<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Domain\Enums\AccountStatus;

class RegisterUserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        $data['status'] = $data['status'] ?? AccountStatus::PENDING->value;
        return $this->userRepository->create($data);
    }
}
