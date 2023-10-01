<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Pattern;

use App\Services\ImageService;

class PatternService
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * パターンタイトルを保存する
     * @param Pattern $pattern
     * @param string $title
     * @return void
     */
    public function saveTitle($pattern, string $title)
    {
        $pattern->title = $title;
    }

    /**
     * パターン本文を保存する
     * @param Pattern $pattern
     * @param string $content
     * @return void
     */
    public function saveContent($pattern, string $content)
    {
        $pattern->content = $content;
    }

    public function store($form)
    {
        $pattern = new Pattern;
        // タイトルと本文をDBに保存
        $this->saveTitle($pattern, $form['title']);
        $this->saveContent($pattern, $form['content']);
        $pattern->save();
        // 画像をDBに保存
        $this->imageService->uploadForPattern($pattern, $form['pattern_images'] ?? []);
    }

    /**
     * 問題にパターンを紐付ける
     * @param Question $question
     * @param array $pattern_ids
     */
    public function attach(Question $question, array $pattern_ids)
    {
        foreach($pattern_ids as $pattern_id) {
            $pattern = Pattern::find($pattern_id);
            $question->patterns()->attach($pattern->id);
        }
    }
}
