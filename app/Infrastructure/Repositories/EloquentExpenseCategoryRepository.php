<?php
namespace App\Infrastructure\Repositories;
use App\Models\ExpenseCategory;
use App\Http\Resources\ExpenseCategoryResource;
use App\Domain\Repositories\ExpenseCategoryRepository;
use Carbon\Carbon;

class EloquentExpenseCategoryRepository implements ExpenseCategoryRepository
{
    public function create(array $data): ?ExpenseCategory
    {
        return ExpenseCategory::create($data);
    }

    public function getAll(int $userId)
    {
       return ExpenseCategoryResource::collection(ExpenseCategory::where('user_id', $userId)->get());
    }

    public function createMany(int $userId, array $categories): array
    {
        $created = [];

        foreach ($categories as $categoryData) {
            $created[] = ExpenseCategory::create([
                'user_id'    => $userId,
                'category'   => $categoryData['category'],
                'limit'      => $categoryData['limit'],
                'limit_type' => $categoryData['limit_type'],
            ]);
        }

        return $created;
    }
}