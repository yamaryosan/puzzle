<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Answer;

use App\Services\ImageService;

use Illuminate\Support\Facades\DB;

class AnswerService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * 正答本文、あれば画像も同時にDBに保存
     *
     * @param Question $question
     * @param string $answerText
     * @param array $files
     * @return Answer $answer
     */
    public function save(Question $question, string $answerText, array $files)
    {
        $answer = new Answer;
        $answer->question_id = $question->id;
        $answer->answer = $answerText;
        $answer->save(); // 正答を保存

        // 画像がある場合
        if ($files) {
            $this->imageService->uploadForAnswer($answer, $files);
        }
        return $answer;
    }

    /**
     * フォームからヒント文のフィールドとその値を取得
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getTextFromForm($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $texts = [];
        foreach ($form[$fieldName] as $key => $value) {
            $texts[$key] = $value;
        }
        return $texts;
    }

    /**
     * フォームから本文IDのフィールドとその値を取得
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getAnswerIdsFromForm($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $answerIds = [];
        foreach ($form[$fieldName] as $key => $value) {
            $answerIds[$key] = $value[0];
        }
        return $answerIds;
    }

    /**
     * フォームから本文画像のフィールドとその値を取得
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getImagesFromForm($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $images = [];
        foreach ($form[$fieldName] as $key => $value) {
            $images[$key] = $value;
        }
        return $images;
    }

    /**
     * 既存ヒントの既存画像の間にアップロードされる新規画像を取得
     * 三次元配列は以下のような構造
     * [ヒント][画像の挿入位置][画像]
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getImagesBetweenExistingImage($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $images = [];
        foreach ($form[$fieldName] as $answerIndex => $answer) {
            foreach ($answer as $positionIndex => $image) {
                $images[$answerIndex][$positionIndex] = $image;
            }
        }
        return $images;
    }

    /**
     * フォームからヒント画像IDのフィールドとその値を取得
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getImageIdsFromForm($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $imageIds = [];
        foreach ($form[$fieldName] as $key => $value) {
            $imageIds[$key] = $value;
        }
        return $imageIds;
    }

    /**
     * 正答をアップロードする
     *
     * @param Question $question
     * @param array $form
     * @return void
     */
    public function store(Question $question, $form)
    {
        // フォームから正答本文に関するフィールドとその値を取得
        $answerTexts = $form['new_answer_text'] ?? [];
        // フォームから正答画像群のフィールドとその値を取得
        $answerImages = $form['new_answer_images']?? [];
        // 本文と画像をペアにして保存
        foreach ($answerTexts as $index => $answerText) {
            $answer = $this->save($question, $answerText, $answerImages[$index] ?? []);
        }
    }
}
