<?php
namespace App\Domain\Services;

use App\Domain\Repositories\ExpenseCategoryRepository;
use App\Domain\Enums\ExpenseCategoryCodes;
use App\Domain\Helpers\Response;
use App\Models\ExpenseCategory;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

/**
 * ?This is not used currently but kept for future reference.
 * directly using eloquent class for this service.
 */
class ExpenseCategoryService
{
    private ExpenseCategoryRepository $expenseCategoryRepository;

    public function __construct(
        ExpenseCategoryRepository $expenseCategoryRepository,
    )
    {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    public function execute(array $data)
    {
        $data = $this->expenseCategoryRepository->create($data);

        return Response::success(
            ExpenseCategoryCodes::SUCCESS,
            'Expense category created!',
            $data
        );
    }
}
