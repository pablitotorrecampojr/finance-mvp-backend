<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseCategoryRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'category'   => [
                'required',
                'string',
                'min:6',
                Rule::unique('expense_categories', 'category')
                    ->where(fn ($query) => $query->where('user_id', $this->user_id)),
            ],
            'limit' => 'required|numeric',
            'limit_type' => 'required|string|in:daily,weekly,monthly,yearly',
        ];
    }

}