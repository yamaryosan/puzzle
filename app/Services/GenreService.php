<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Genre;
use App\Models\Image;

use App\Services\ImageService;

class GenreService
{
    public function areNewGenreTextsEmpty(array $newGenreTexts)
    {
        foreach ($newGenreTexts as $newGenreText) {
            if(!empty($newGenreText)){
                return false;
            }
        }
        return true;
    }

    public function attach(Question $question, array $existingGenreIdsChecked, array $newGenreTexts)
    {
        $question->genres()->detach(); // 中間テーブルから削除

        // 既存ジャンルも新規ジャンルも選択されていない場合は「ジャンルなし」を問題に紐づける
        if (empty($existingGenreIdsChecked) && $this->areNewGenreTextsEmpty($newGenreTexts)) {
            $genre = Genre::firstOrCreate(['genre' => 'ジャンルなし']); // 重複する場合は作成しない
            $question->genres()->attach($genre->id); // 中間テーブルに保存
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
