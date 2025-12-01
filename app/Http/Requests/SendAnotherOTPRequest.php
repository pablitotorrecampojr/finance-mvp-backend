<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SendAnotherOTPRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'=> 'required|integer',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ];
    }
}