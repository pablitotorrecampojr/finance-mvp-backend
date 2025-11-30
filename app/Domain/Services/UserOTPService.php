<?php
namespace App\Domain\Services;

use App\Domain\Repositories\IUserOTPRepository;;
use App\Models\User;
use App\Domain\Enums\AccountStatus;

class UserOTPService
{
    private IUserOTPRepository $IuserOTPRespository;

    public function __construct(
        IUserOTPRepository $IuserOTPRespository
    )
    {
        $this->IuserOTPRespository = $IuserOTPRespository;
    }

    public function execute(int $userId, string $value)
    {
        return $this->IuserOTPRespository->verify($userId, $value);
    }
}
