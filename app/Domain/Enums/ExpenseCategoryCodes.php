<?php
namespace App\Domain\Enums;

enum ExpenseCategoryCodes: string
{
    case SUCCESS = 'EXPENSE_CATEGORY_CREATED';
    case FAILED = "EXPENSE_CATEGORY_FAILED";
}