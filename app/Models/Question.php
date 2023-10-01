<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * 問題からジャンルを取得
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_question');
    }

    /**
     * 問題からパターンを取得
     */
     public function patterns()
    {
        return $this->belongsToMany(Pattern::class, 'pattern_question');
    }

    /**
     * 問題から画像を取得
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_question');
    }
}
