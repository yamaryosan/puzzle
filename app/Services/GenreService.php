<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Genre;
use App\Models\Image;

use App\Services\ImageService;

class GenreService
{
    public function attach(Question $question, array $existingGenreIdsChecked, array $newGenreTexts)
    {
        $question->genres()->detach(); // 中間テーブルから削除
        if (empty($existingGenreIdsChecked) && empty($newGenreTexts)) {
            return;
        }

        // 既存ジャンルを問題に紐づける
        foreach ($existingGenreIdsChecked as $existing_genre_id) {
            $genre = Genre::find($existing_genre_id);
            $question->genres()->attach($genre->id); // 中間テーブルに保存
        }

        // 新規ジャンルを作成し、問題に紐づける
        foreach ($newGenreTexts as $newGenreText) {
            if(!empty($newGenreText)){
                $genre = Genre::firstOrCreate(['genre' => $newGenreText]); // 重複する場合は作成しない
                $question->genres()->syncWithoutDetaching($genre->id); // 中間テーブルに保存
            }
        }
    }
}
