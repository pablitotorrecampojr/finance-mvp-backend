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

    /**
     * TODO: insert expense category
     * Store a newly created exp in storage.
     */
    public function createCategory(ExpenseCategoryRequest $request)
    {
        $data = $request->validated();
        $response = $this->expenseCategoryService->execute($data);
        return $response;
    }
}
