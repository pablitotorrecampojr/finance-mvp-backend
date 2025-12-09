<?php
namespace App\Infrastructure\Repositories;
use App\Models\ExpenseCategory;
use App\Domain\Repositories\ExpenseCategoryRepository;
use Carbon\Carbon;

class EloquentExpenseCategoryRepository implements ExpenseCategoryRepository
{
    public function create(array $data): ?ExpenseCategory
    {
        return ExpenseCategory::create($data);
    }
    
}