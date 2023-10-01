<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Hint;

use App\Services\ImageService;

use Illuminate\Support\Facades\DB;

class HintService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * ヒント本文、あれば画像も同時にDBに保存
     *
     * @param Question $question
     * @param string $hint_text
     * @param array $files
     * @return Hint $hint
     */
    public function save(Question $question, string $hint_text, array $files = [])
    {
        $hint = new Hint;
        $hint->question_id = $question->id;
        $hint->hint = $hint_text;
        $hint->save(); // ヒントを保存

        // 画像がある場合
        if ($files) {
            $this->imageService->uploadForHint($hint, $files);
        }
        return $hint;
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
     * フォームからヒントIDのフィールドとその値を取得
     * @param array $form
     * @param string $fieldName
     * @return array
     */
    public function getHintIdsFromForm($form, string $fieldName)
    {
        if (!isset($form[$fieldName])) {
            return [];
        }
        $hintIds = [];
        foreach ($form[$fieldName] as $key => $value) {
            $hintIds[$key] = $value[0];
        }
        return $hintIds;
    }

    /**
     * フォームからヒント画像のフィールドとその値を取得
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
        foreach ($form[$fieldName] as $hintIndex => $hint) {
            foreach ($hint as $positionIndex => $image) {
                $images[$hintIndex][$positionIndex] = $image;
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
     * ヒントをアップロードしてDBに保存
     * text_hint_n(nは自然数): ヒント本文
     * hint_images_n(nは自然数): ヒント画像
     *
     * text_hint_nとhint_images_nをペアとして扱う
     * 例: text_hint_1とhint_images_1は同じヒントの本文と画像
     * ただし、text_hint_nがrequiredなのに対し、hint_images_nは任意
     * また、JSファイルでヒントの追加・削除ができるため、
     * 番号は空番になる可能性がある
     * 画像がないヒントはtext_hint_nのみで保存する
     *
     * @param Question $question
     * @param array $form
     * @return void
     */
    public function store(Question $question, array $form)
    {
        // フォームからヒント文のフィールドとその値を取得
        $hintTexts = $form['new_hint_text'] ?? [];
        // フォームからヒント画像群のフィールドとその値を取得
        $hintImages = $form['new_hint_images'] ?? [] ;
        // 本文と画像をペアにして保存
        foreach ($hintTexts as $index => $hintText) {
            $hint = $this->save($question, $hintText, $hintImages[$index] ?? []);
        }
    }
}
