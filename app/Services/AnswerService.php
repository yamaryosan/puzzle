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
     * 正答を保存する
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

    /**
     * 元々画像のなかった正答を再作成
     * @param Question $question
     * @param array $answerIds
     * @param array $texts
     * @param array $images
     * @return void
     */
    public function restoreAnswersOriginallyNoImage(Question $question, array $answerIds, array $texts, array $images)
    {
        if (!isset($answerIds)) {
            return;
        }
        # dd($answerIds, $texts, $images);
        foreach ($answerIds as $answerIndex => $answerId) {
            $answer = new Answer;
            $answer->question_id = $question->id;
            $answer->answer = $texts[$answerIndex];
            $answer->save();
            // 新規画像の保存
            if (isset($images[$answerIndex])) {
                $this->imageService->uploadForAnswer($answer, $images[$answerIndex]);
            }
        }
    }

    /**
     * 元々画像のあった正答の本文を更新し、画像を紐付ける
     * @param Question $question
     * @param array $answerIds
     * @param array $texts
     * @param array $imageIds
     * @param array $images
     * @return void
     */
    public function restoreAnswersOriginallyWithImage(
        Question $question,
        array $answerIds,
        array $texts,
        array $imageIds,
        array $images)
    {
        # dd($answerIds, $texts, $imageIds, $images);
        if (empty($answerIds)) {
            return;
        }
        $loopMax = max(count($imageIds[0]), count($images[0]));
        foreach ($answerIds as $answerIndex => $answerId) {
            $answer = new Answer;
            $answer->question_id = $question->id;
            $answer->answer = $texts[$answerIndex];
            $answer->save();
            // 新規画像の保存と既存画像の紐付け
            for ($i = 0; $i<= $loopMax; $i++) {
                // 新規画像の保存
                if (isset($images[$answerIndex][$i])) {
                    $this->imageService->uploadForAnswer($answer, $images[$answerIndex][$i]);
                }
                // 既存画像の紐付け
                if (isset($imageIds[$answerIndex][$i])) {
                    $this->imageService->reAttachForAnswer($answer, $imageIds[$answerIndex][$i]);
                }
            }
        }
    }

    /**
     * 一時的な既存画像なし正答を連想配列として作成
     */
    public function prepareTempAnswersOriginallyNoImage(array $form)
    {
        if (!isset($form['answer_ids_originally_no_image'])) {
            return [];
        }
        $tempAnswers = [];
        // 元々画像のなかった正答のIDを取得
        $answerIds = $this->getAnswerIdsFromForm($form, 'answer_ids_originally_no_image');
        // 元々画像のなかったヒント文のフィールドとその値を取得
        $answerTexts = $this->getTextFromForm($form, 'answer_text_originally_no_image');
        // 元々画像のなかったヒントの画像群を取得
        $answerImages = $this->getImagesFromForm($form, 'answer_images_originally_no_image');
        // 元々画像のなかったヒントのフィールドとその値を連想配列に格納
        foreach ($answerIds as $index => $answerId) {
            $tempAnswers[$answerId] = [
                'answer_text' => $answerTexts[$index],
                'answer_images' => $answerImages[$index] ?? [], // 画像がない場合は空配列
            ];
        }
        return $tempAnswers;
    }


    /**
     * 一時的な既存画像あり正答を連想配列として作成
     */
    public function prepareTempAnswersOriginallyWithImage(array $form)
    {
        if (!isset($form['answer_ids_originally_with_image'])) {
            return [];
        }
        $tempAnswers = [];
        // 元々画像のあった正答のIDを取得
        $answerIds = $this->getAnswerIdsFromForm($form, 'answer_ids_originally_with_image');
        // 元々画像のあった正答のフィールドとその値を取得
        $answerTexts = $this->getTextFromForm($form, 'answer_text_originally_with_image');
        // 元々画像のあった正答画像群のフィールドとその値(ID)を取得
        $answerImageIds = $this->getImageIdsFromForm($form, 'answer_image_ids_originally_with_image');
        // 元々画像のあった正答に追加された新規画像群のフィールドとその値を取得
        $answerNewImages = $this->getImagesBetweenExistingImage($form, 'answer_new_images_originally_with_image');

        // 元々画像のあったヒントのフィールドとその値を連想配列に格納
        foreach ($answerIds as $answerIndex => $answerId) {
            $tempAnswers[$answerId] = [
                'answer_text' => $answerTexts[$answerIndex] ?? [],
                'answer_image_ids' => $answerImageIds[$answerIndex] ?? [], // 画像がない場合は空配列
                'answer_new_images' => $answerNewImages[$answerIndex] ?? [], // 画像がない場合は空配列
            ];
        }
        return $tempAnswers;
    }

    /**
     * 正答を更新する
     * @param Question $question
     * @param array $form
     * @param int $questionId
     * @return void
     */
    public function update(Question $question, array $form, string $questionId)
    {
        DB::transaction(function () use ($question, $form, $questionId) {
            // 一時的な正答を連想配列として作成
            $tempAnswersOriginallyNoImage = $this->prepareTempAnswersOriginallyNoImage($form);
            $tempAnswersOriginallyWithImage = $this->prepareTempAnswersOriginallyWithImage($form);
            // 既存の正答をいったん全て削除
            Answer::where('question_id', $questionId)->delete();

            // 既存画像のなかった正答の更新(再作成)
            $this->restoreAnswersOriginallyNoImage(
                $question,
                array_keys($tempAnswersOriginallyNoImage),
                array_column($tempAnswersOriginallyNoImage, 'answer_text'),
                array_column($tempAnswersOriginallyNoImage, 'answer_images'),
            );

            // 既存画像のあった正答の更新(再作成)
            $this->restoreAnswersOriginallyWithImage(
                $question,
                array_keys($tempAnswersOriginallyWithImage),
                array_column($tempAnswersOriginallyWithImage, 'answer_text'),
                array_column($tempAnswersOriginallyWithImage, 'answer_image_ids'),
                array_column($tempAnswersOriginallyWithImage, 'answer_new_images'),
            );

            // 新規正答の保存
            $this->store($question, $form);
        });
    }
}
