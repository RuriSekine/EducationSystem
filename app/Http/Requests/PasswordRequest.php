<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => '入力必須項目です',
            'new_password.required' => '入力必須項目です',
            'new_password.min' => 'パスワードは8文字以上で入力してください',
            'new_password.confirmed' => '新しいパスワードが一致しません',
        ];
    }
}
