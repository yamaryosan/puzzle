<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AnyGenreSelected;

class QuestionRequest extends FormRequest
{
    private int $titleStrlen = 100;
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
        /**
         * 配列が空の場合、バリデーションがスルーされてしまうので、
         * nullを追加する
         */
        $this->merge([
            'existing_genre_ids_checked' => $this->existing_genre_ids_checked ?? null,
        ]);

        return [
            'title' => "required|max:{$this->titleStrlen}",
            'content' => 'required',
            'existing_genre_ids_checked' => [new AnyGenreSelected()],
            'new_genre_texts' => [new AnyGenreSelected()],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルを入力してください',
            'title.max' => "タイトルは{$this->titleStrlen}文字以内で入力してください",
            'content.required' => '問題文を入力してください',
        ];
    }
}
