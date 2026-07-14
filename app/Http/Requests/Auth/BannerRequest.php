<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
     //バナー管理のバリデーションルールを定義する
    public function rules()
    {
        return [
            'new_images'   => 'nullable|array',
            'new_images.*' => 'nullable|file|mimes:jpeg,png|max:5242880',
            'images'       => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png|max:5242880',
        ];
    }

    public function messages()
    {
        return [
            'new_images.*.file'  => 'ファイルを選択してください',
            'new_images.*.mimes'    => 'PNGまたはJPEG形式のファイルを選択してください',
            'new_images.*.max'      => 'ファイルサイズは5MB以内にしてください',
            'images.*.mimes'        => 'PNGまたはJPEG形式のファイルを選択してください',
            'images.*.max'          => 'ファイルサイズは5MB以内にしてください',
        ];
    }
}
