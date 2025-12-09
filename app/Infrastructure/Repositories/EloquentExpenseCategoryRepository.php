<?php
namespace App\Infrastructure\Repositories;
use App\Models\ExpenseCategory;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use Carbon\Carbon;

class EloquentPasswordResetTokenRepository implements IPasswordResetTokenRepository
{
    public function create(ExpenseCategory $data): ?ExpenseCategory
    {
        return ExpenseCategory::create($data);
    }
    
}