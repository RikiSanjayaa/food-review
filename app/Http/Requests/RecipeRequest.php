<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ingredients' => ['required', 'string'],
            'steps' => ['required', 'string'],
            'prep_time' => ['nullable', 'integer', 'min:0'],
            'cook_time' => ['nullable', 'integer', 'min:0'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['nullable', 'string', 'max:50'],
            'diet' => ['nullable', 'string', 'max:50'],
            'cuisine' => ['nullable', 'string', 'max:100'],
            'hero_image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul resep wajib diisi.',
            'title.max' => 'Judul resep tidak boleh lebih dari 255 karakter.',
            'ingredients.required' => 'Bahan-bahan wajib diisi.',
            'steps.required' => 'Langkah-langkah pembuatan wajib diisi.',
            'prep_time.integer' => 'Waktu persiapan harus berupa angka.',
            'cook_time.integer' => 'Waktu masak harus berupa angka.',
            'servings.integer' => 'Jumlah porsi harus berupa angka.',
            'hero_image.image' => 'File yang diunggah harus berupa gambar.',
            'hero_image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}

