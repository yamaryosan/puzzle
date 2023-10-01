<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * 正答から画像を取得
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'answer_image');
    }
}
