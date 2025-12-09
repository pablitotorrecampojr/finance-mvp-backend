<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

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
            'category' => 'required|string|min:6',
            'limit' => 'required|numeric',
            'limit_type' => 'required|string|in:daily,weekly,monthly,yearly',
        ];
    }

}