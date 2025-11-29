<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\IUserOTPRepository;;
use App\Models\User;
use App\Domain\Enums\AccountStatus;

class RegisterUserService
{
    private UserRepositoryInterface $userRepository;
    private IUserOTPRepository $IuserOTPRespository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IUserOTPRepository $IuserOTPRespository
    )
    {
        $this->userRepository = $userRepository;
        $this->IuserOTPRespository = $IuserOTPRespository;
    }

    public function execute(array $data): User
    {
        $data['status'] = $data['status'] ?? AccountStatus::PENDING->value;
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);
        $this->IuserOTPRespository->send($user);
        return $user;
    }
}
