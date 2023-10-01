<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    /**
     * パターンから問題を取得
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'pattern_question');
    }

    /**
     * パターンから画像を取得
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_pattern');
    }
}
