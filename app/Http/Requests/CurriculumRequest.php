<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //学年
            'grade_id' => 'required|exists:grades,id',
            // サムネイル
            'thumbnail' => 'nullable|image|mimes:jpg,png|max:51200', // 50MB
            // 授業名
            'title' => 'required|string|max:255',
            // 動画URL
            'video_url' => 'required|url',
            // 授業概要
            'description' => 'required|string|max:255',
            //常時公開フラグ
            'always_delivery' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            // サムネイル
            'thumbnail.image' => '登録できる画像形式はjpg,png形式です。',
            'thumbnail.mimes' => '登録できる画像形式はjpg,png形式です。',
            'thumbnail.max' => '画像サイズが50MBを超えています。',
            // 授業名
            'title.required' => '授業名は入力必須項目です。',
            'title.max' => '授業名は255文字以内で入力してください。',
            // 動画URL
            'video_url.required' => '動画URLは入力必須項目です。',
            'video_url.url' => 'URLの入力をしてください。',
            // 授業概要
            'description.required' => '授業概要は入力必須項目です。',
            'description.max' => '授業概要は255文字以内で入力してください。',
        ];
    }
}
