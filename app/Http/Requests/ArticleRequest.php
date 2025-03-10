<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * 認可ロジック (必要ならtrueを返す)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'article_contents' => 'required|string',
            'posted_date' => 'nullable|date',
        ];
    }
}
