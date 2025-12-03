<?php
namespace App\Domain\Enums;

enum OTPResponseCodes: string
{
    case REQUIRED = 'OTP_IS_REQUIRED';
    case NOTFOUND = 'OTP_NOT_FOUND';
    case EXPIRED = 'OTP_HAS_EXPIRED';
    case MISMATCH = 'OTP_MISMATCH';
    case SUCCESS = 'OTP_VERIFIED';
}