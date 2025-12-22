<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Domain\Repositories\ExpenseCategoryRepository;
use App\Domain\Services\ExpenseCategoryService;
use App\Domain\Enums\ExpenseCategoryCodes;

class ExpenseController extends Controller
{
    private ExpenseCategoryService $expenseCategoryService;

    public function __construct(
        ExpenseCategoryService $expenseCategoryService
    )
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }
    
    public function index(Request $request, ExpenseCategoryRepository $repository) 
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer'
            ]);

            $userId = $data['user_id'];
            $categories = $repository->getAll($userId);

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved expense categories',
                'code'    => ExpenseCategoryCodes::SUCCESS,
                'data'    => $categories
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get all categories',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    public function store(ExpenseCategoryRequest $request, ExpenseCategoryRepository $repository)
    {
        try {
            $data = $request->validated();
            $userId = $data['user_id'];
            $categories = $data['categories'];

            $created = $repository->createMany($userId, $categories);
            \Log::info('ExpenseController@store', ['created' => $created]);
            return response()->json([
                'success' => true,
                'message' => 'Categories stored successfully!',
                'code'    => ExpenseCategoryCodes::SUCCESS,
                'data'    => $created,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store categories',
                'code'    => ExpenseCategoryCodes::FAILED,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
