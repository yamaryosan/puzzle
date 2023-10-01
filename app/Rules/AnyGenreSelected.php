<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AnyGenreSelected implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $request = request();
        $existingGenres = $request->input('existing_genre_ids_checked');
        $newGenreTexts = $request->input('new_genre_texts');
        /**
         * バリデーションをスルーさせないために、
         * 新ジャンルテキストに入力が何もない場合、配列にnullを代入
         */
        if (empty(array_filter($newGenreTexts, 'strlen'))) {
            $newGenreTexts = null;
        }

        /**
         * 既存ジャンルと新ジャンルの両方が空の場合、
         * バリデーションエラー
         */
        if (empty($existingGenres) && empty($newGenreTexts)) {
            $fail('既存ジャンルまたは新ジャンルを選択してください');
        }
    }
}
