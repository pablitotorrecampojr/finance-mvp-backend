<?php
namespace App\Domain\Enums;

enum ExpenseCategoryCodes: string
{
    case SUCCESS = 'EXPENSE_CATEGORY_SUCCESS';
    case CREATED = 'EXPENSE_CATEGORY_CREATED';
    case FAILED = "EXPENSE_CATEGORY_FAILED";
    case MISSING = 'EXPENSE_CATEGORY_IS_MISSING';
}