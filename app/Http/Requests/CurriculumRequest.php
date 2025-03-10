<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'grade_id' => 'required|exists:grades,id',
        ];
    }
}
