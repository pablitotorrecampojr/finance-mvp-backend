<?php
namespace App\Domain\Enums;

enum ExpenseCategoryFlags: string
{
    case NEW = 'new';
    case UPDATED = 'updated';
    case REMOVED = 'removed';
}