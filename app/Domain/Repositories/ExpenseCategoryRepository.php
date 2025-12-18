<?php
namespace App\Domain\Repositories;
use App\Models\ExpenseCategory;

interface ExpenseCategoryRepository
{
    public function getAll(int $userId);
    public function createMany(int $userId, array $categories): array;
}