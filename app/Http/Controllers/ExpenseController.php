<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Domain\Repositories\ExpenseCategoryRepository;
use App\Domain\Services\ExpenseCategoryService;

class ExpenseController extends Controller
{
    private ExpenseCategoryService $expenseCategoryService;

    public function __construct(
        ExpenseCategoryService $expenseCategoryService
    )
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    public function store(ExpenseCategoryRequest $request, ExpenseCategoryRepository $repository)
    {
        try {
            $data = $request->validated();
            $userId = $data['user_id'];
            $categories = $data['categories'];
        
            $created = $repository->createMany($userId, $categories);
            return response()->json([
                'success' => true,
                'message' => 'Categories stored successfully!',
                'data'    => $created,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store categories',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
