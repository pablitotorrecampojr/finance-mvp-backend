<?php
namespace App\Domain\Enums;

enum ForgotPasswordCodes: string
{
    case INVALID = 'FORGOT_PASSWORD_INVALID';
    case MISMATCH = 'FORGOT_PASSWORD_EMAIL_NOTFOUND';
    case SUCCESS = 'FORGOT_PASSWORD_SENT';
}