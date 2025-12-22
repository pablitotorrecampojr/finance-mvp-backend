<?php
namespace App\Infrastructure\Repositories;
use App\Models\ExpenseCategory;
use App\Http\Resources\ExpenseCategoryResource;
use App\Domain\Repositories\ExpenseCategoryRepository;
use App\Domain\Enums\ExpenseCategoryFlags;
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
        try {
            //TODO: implement batch insert/update/delete
            $created = [];
            foreach ($categories as $categoryData) {
                switch ($categoryData['flag']) {
                    case ExpenseCategoryFlags::NEW->value:
                        $created[] = ExpenseCategory::create([
                            'user_id'    => $userId,
                            'category'   => $categoryData['category'],
                            'limit'      => $categoryData['limit'],
                            'limit_type' => $categoryData['limit_type'],
                        ]);
                        break;
                    case ExpenseCategoryFlags::UPDATED->value:
                        ExpenseCategory::where('id', $categoryData['id'])
                            ->where('user_id', $userId)
                            ->update([
                                'category'   => $categoryData['category'],
                                'limit'      => $categoryData['limit'],
                                'limit_type' => $categoryData['limit_type'],
                                'updated_at' => Carbon::now(),
                            ]);
                        break;
                    case ExpenseCategoryFlags::REMOVED->value:
                        ExpenseCategory::where('id', $categoryData['id'])
                            ->where('user_id', $userId)
                            ->delete();
                        break;
                    
                    default:
                        $created[] = null;
                        break;
                }
            }

            //TODO: return mapped resource
            foreach ($created as $key => $item) {
                if ($item !== null) {
                    $created[$key] = new ExpenseCategoryResource($item);
                }
            }

            return $created;
        } catch (\Throwable $th) {
            \Log::error('EloquentExpenseCategoryRepository@createMany', ['error' => $th->getMessage()]);
            throw $th;
        }
    }
}