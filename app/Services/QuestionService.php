<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Genre;
use App\Models\Hint;
use App\Models\Image;
use App\Models\Answer;
use App\Models\Pattern;

use App\Services\ImageService;
use App\Services\HintService;
use App\Services\GenreService;
use App\Services\PatternService;
use App\Services\AnswerService;

class QuestionService
{
    protected $imageService;

    public function __construct(
        ImageService $imageService,
        HintService $hintService,
        GenreService $genreService,
        PatternService $patternService,
        AnswerService $answerService
        )
    {
        $this->imageService = $imageService;
        $this->hintService = $hintService;
        $this->genreService = $genreService;
        $this->patternService = $patternService;
        $this->answerService = $answerService;
    }

    /**
     * 問題タイトルを保存する
     * @param Question $question
     * @param string $title
     * @return void
     */
    public function saveTitle($question, string $title)
    {
        $question->title = $title;
    }

    /**
     * 問題文を保存する
     * @param Question $question
     * @param string $content
     * @return void
     */
    public function saveContent($question, string $content)
    {
        $question->content = $content;
    }

    /**
     * 問題文に画像を追加する
     * @param Question $question
     * @param array $form
     * @return void
     */
    public function attachImages(Question $question, array $form)
    {
        dd($form);
        if (!isset($form['existing_image_ids_checked'])) {
            $form['existing_image_ids_checked'] = [];
        }
        // 既存画像を問題に紐づける
        foreach ($form['existing_image_ids_checked'] as $imageId) {
            $image = Image::find($imageId);
            $question->images()->attach($image->id); // 中間テーブルに保存
        }

        // 新規画像をアップロードし、問題に紐づける
        if (!empty($form['question_images'])) {
            $newImages = $form['question_images'];
            $this->imageService->uploadForQuestion($question, $newImages);
        }
    }

    /**
     * 問題を保存する
     * @param array $form
     */
    public function store(array $form)
    {
        $question = new Question;
        // 問題文をDBに保存
        $this->saveTitle($question, $form['title']);
        $this->saveContent($question, $form['content']);
        $question->save();
        // 問題文用の画像をDBに保存
        $this->imageService->uploadForQuestion($question, $form['question_images'] ?? []);
        // ジャンルを問題文に紐付ける
        $this->genreService->attach($question, $form['existing_genre_ids_checked'] ?? [], $form['new_genre_text'] ?? []);
        // ヒントをDBに保存
        $this->hintService->store($question, $form);
        // パターンを問題文に紐付ける
        $this->patternService->attach($question, $form['pattern_ids'] ?? []);
        // 正答をDBに保存
        $this->answerService->store($question, $form);
    }

    /**
     * 問題を更新する
     * @param Question $question
     * @param array $form
     * @param string $id
     */
    public function update(Question $question, array $form, string $id)
    {
        // 問題文の更新
        $this->saveTitle($question, $form['title']);
        $this->saveContent($question, $form['content']);
        $question->save();

        // 問題文用の画像の更新
        $this->imageService->updateForQuestion(
            $question,
            $form['existing_question_image_ids'] ?? [],
            $form['new_question_images'] ?? [],
        );

        // ジャンルの更新
        $this->genreService->attach($question, $form['existing_genre_ids_checked'] ?? [], $form['new_genre_text'] ?? []);

        // ヒントの更新
        $this->hintService->update($question, $form, $id);

        // パターンの更新
        $question->patterns()->detach(); // 中間テーブルから削除
        if (!isset($form['pattern_ids'])) {
            $form['pattern_ids'] = [];
        }
        $patternIds = $form['pattern_ids'];
        foreach ($patternIds as $patternId) {
            $question->patterns()->attach($patternId);
        }

        // 正答の更新
        $this->answerService->update($question, $form, $id);
    }


}
