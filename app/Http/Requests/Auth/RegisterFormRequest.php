<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
     //新規登録フォームのバリデーションルールを定義する
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:admins|regex:/^(?!.*[ｦ-ﾟ]).+$/u',
            'kana' => 'required|max:255|unique:admins|regex:/^[ァ-ヶー]+$/u',
            'email' => 'required|max:255|unique:admins',
            'password' => 'required|min:8|max:255|confirmed',
            'password_confirmation' => 'required|min:8|max:255',
        ];
    }

    public function messages()
    {
    return [
        'name.required' => 'ユーザーネームを入力してください。',
            'name.unique' => 'そのユーザーネームは既に登録されています。',
            'name.regex' => '全角で入力してください。',
            'kana.required' => 'カナを入力してください。',
            'kana.unique' => 'そのカナは既に登録されています。',
            'kana.regex' => '全角カタカナで入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.unique' => 'そのメールアドレスは既に登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上である必要があります。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password_confirmation.required' => 'パスワード確認が入力されていません。',
            'password_confirmation.min' => 'パスワードは8文字以上である必要があります。',
    ];
    }
}
