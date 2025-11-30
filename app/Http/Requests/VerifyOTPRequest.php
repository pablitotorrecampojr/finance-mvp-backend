<?php
namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOTPRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'=> 'required|integer',
            'value' => 'required|string',
        ];
    }
}