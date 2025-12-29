<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'exists:reviews,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Mohon berikan rating bintang.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.max' => 'Komentar tidak boleh lebih dari 1000 karakter.',
        ];
    }
}

