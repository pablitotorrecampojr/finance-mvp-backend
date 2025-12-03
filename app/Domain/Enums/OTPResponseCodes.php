<?php
namespace App\Domain\Enums;

enum OTPResponseCodes: string
{
    case NOTFOUND = 'otp_not_found';
    case EXPIRED = 'otp_has_expired';
    case MISMATCH = 'otp_mismatch';
    case SUCCESS = 'otp_verified';
}