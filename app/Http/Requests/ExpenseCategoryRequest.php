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
            'categories' => 'required|array|min:1',
            'categories.*id' => 'required|integer',
            'categories.*.category' => [
                'required',
                'string',
                'min:3',
                Rule::when(
                    fn ($input) => $input['flag'] === 'new',
                    Rule::unique('expense_categories', 'category')
                        ->where(fn ($query) => $query->where('user_id', $this->user_id))
                )
            ],
            'categories.*.limit' => 'required|numeric',
            'categories.*.limit_type' => 'required|string|in:daily,weekly,monthly,yearly',
            'categories.*.flag' => 'required|string|in:new,updated,removed'
        ];
    }

}