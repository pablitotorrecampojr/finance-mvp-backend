<?php
namespace App\Domain\Repositories;
use App\Models\ExpenseCategory;

interface ExpenseCategoryRepository
{
    public function create(array $data): ?ExpenseCategory;
    public function createMany(int $userId, array $categories): array;
}