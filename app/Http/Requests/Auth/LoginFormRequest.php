<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
     //ログインフォームのバリデーションルールを定義する
    public function rules()
    {
        return [
            'email' => 'required|max:255|email',
            'password' => 'required|min:8|max:255',
        ];
    }

    public function messages()
    {
    return [
        'email.required' => 'メールアドレスを入力してください。',
        'email.email' => '有効なメールアドレスを入力してください。',
        'email.max' => 'メールアドレスは255文字以内で入力してください。',

        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上である必要があります。',
        'password.max' => 'パスワードは255文字以内で入力してください。',
    ];
    }
}
