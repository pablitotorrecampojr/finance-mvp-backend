<?php
namespace App\Domain\Services;

use App\Domain\Repositories\IUserOTPRepository;;
use App\Models\User;
use App\Domain\Enums\AccountStatus;
use Carbon\Carbon;

class SendAnotherOTPService
{
    private IUserOTPRepository $IuserOTPRespository;

    public function __construct(
        IUserOTPRepository $IuserOTPRespository
    )
    {
        $this->IuserOTPRespository = $IuserOTPRespository;
    }

    public function execute(array $data)
    {
        $this->IuserOTPRespository->send($user);
    }
}
