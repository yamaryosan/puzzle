<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'genre' => 'required|max:255|unique:genres,genre,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'genre.required' => 'ジャンル名を入力してください',
            'genre.max' => 'ジャンル名は255文字以内で入力してください',
            'genre.unique' => 'そのジャンル名は既に登録されています',
        ];
    }
}
