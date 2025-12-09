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
            'category' => 'required|string',
            'limit' => 'required|double',
            'limit_type' => 'required|string'
        ];
    }

}