<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hint extends Model
{
    use HasFactory;

    /**
     * ヒントから画像を取得
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'hint_image');
    }
}
