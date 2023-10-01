<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * 画像から問題を取得
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'image_question');
    }

    /**
     * 画像からヒントを取得
     */
     public function hints()
     {
        return $this->belongsToMany(Hint::class, 'hint_image');
     }

     /**
      * 画像から正答を取得
      */
      public function answers()
      {
        return $this->belongsToMany(Answer::class, 'answer_image');
      }
}
