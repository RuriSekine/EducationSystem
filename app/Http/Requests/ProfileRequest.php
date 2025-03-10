<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id; // 現在のユーザーIDを取得

        return [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヴー\s]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }
}
