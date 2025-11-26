<?php
namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserReqquest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

}