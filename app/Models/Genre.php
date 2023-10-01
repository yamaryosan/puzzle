<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * ジャンルから問題を取得
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'genre_question');
    }
}
