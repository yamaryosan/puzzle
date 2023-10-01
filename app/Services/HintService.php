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
     * ヒントを保存
     *
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

    /**
     * 元々画像のなかったヒントを再作成
     * @param Question $question
     * @param array $hintIds
     * @param array $texts
     * @param array $images
     * @return void
     */
    public function restoreHintsOriginallyNoImage(Question $question, array $hintIds, array $texts, array $images)
    {
        if (!isset($hintIds)) {
            return;
        }
        # dd($hintIds, $texts, $images);
        foreach ($hintIds as $hintIndex => $hintId) {
            $hint = new Hint;
            $hint->question_id = $question->id;
            $hint->hint = $texts[$hintIndex];
            $hint->save();
            // 新規画像の保存
            if (isset($images[$hintIndex])) {
                $this->imageService->uploadForHint($hint, $images[$hintIndex]);
            }
        }
    }

    /**
     * 元々画像のあったヒントの本文を更新し、画像を紐付ける
     * @param Question $question
     * @param array $hintIds
     * @param array $texts
     * @param array $imageIds
     * @param array $images
     * @return void
     */
    public function restoreHintsOriginallyWithImage(
        Question $question,
        array $hintIds,
        array $texts,
        array $imageIds,
        array $images)
    {
        # dd($hintIds, $texts, $imageIds, $images);
        if (empty($hintIds)) {
            return;
        }
        $loopMax = max(count($imageIds[0]), count($images[0]));
        foreach ($hintIds as $hintIndex => $hintId) {
            $hint = new Hint;
            $hint->question_id = $question->id;
            $hint->hint = $texts[$hintIndex];
            $hint->save();
            // 新規画像の保存と既存画像の紐付け
            for ($i = 0; $i<= $loopMax; $i++) {
                // 新規画像の保存
                if (isset($images[$hintIndex][$i])) {
                    $this->imageService->uploadForHint($hint, $images[$hintIndex][$i]);
                }
                // 既存画像の紐付け
                if (isset($imageIds[$hintIndex][$i])) {
                    $this->imageService->reAttachForHint($hint, $imageIds[$hintIndex][$i]);
                }
            }
        }
    }

    /**
     * 一時的な既存画像なしヒントを連想配列として作成
     */
    public function prepareTempHintsOriginallyNoImage(array $form)
    {
        if (!isset($form['hint_ids_originally_no_image'])) {
            return [];
        }
        $tempHints = [];
        // 元々画像のなかったヒントのIDを取得
        $hintIds = $this->getHintIdsFromForm($form, 'hint_ids_originally_no_image');
        // 元々画像のなかったヒント文のフィールドとその値を取得
        $hintTexts = $this->getTextFromForm($form, 'hint_text_originally_no_image');
        // 元々画像のなかったヒントの画像群を取得
        $hintImages = $this->getImagesFromForm($form, 'hint_images_originally_no_image');
        // 元々画像のなかったヒントのフィールドとその値を連想配列に格納
        foreach ($hintIds as $index => $hintId) {
            $tempHints[$hintId] = [
                'hint_text' => $hintTexts[$index],
                'hint_images' => $hintImages[$index] ?? [], // 画像がない場合は空配列
            ];
        }
        return $tempHints;
    }

    /**
     * 一時的な既存画像ありヒントを連想配列として作成
     */
    public function prepareTempHintsOriginallyWithImage(array $form)
    {
        if (!isset($form['hint_ids_originally_with_image'])) {
            return [];
        }
        $tempHints = [];
        // 元々画像のあったヒントのIDを取得
        $hintIds = $this->getHintIdsFromForm($form, 'hint_ids_originally_with_image');
        // 元々画像のあったヒント文のフィールドとその値を取得
        $hintTexts = $this->getTextFromForm($form, 'hint_text_originally_with_image');
        // 元々画像のあったヒント画像群のフィールドとその値(ID)を取得
        $hintImageIds = $this->getImageIdsFromForm($form, 'hint_image_ids_originally_with_image');
        // 元々画像のあったヒントに追加された新規画像群のフィールドとその値を取得
        $hintNewImages = $this->getImagesBetweenExistingImage($form, 'hint_new_images_originally_with_image');

        // 元々画像のあったヒントのフィールドとその値を連想配列に格納
        foreach ($hintIds as $hintIndex => $hintId) {
            $tempHints[$hintId] = [
                'hint_text' => $hintTexts[$hintIndex] ?? [],
                'hint_image_ids' => $hintImageIds[$hintIndex] ?? [], // 画像がない場合は空配列
                'hint_new_images' => $hintNewImages[$hintIndex] ?? [], // 画像がない場合は空配列
            ];
        }
        return $tempHints;
    }

    /**
     * ヒントを更新
     * @param Question $question
     * @param array $form
     * @param string $questionId
     */
    public function update(Question $question, array $form, string $questionId)
    {
        DB::transaction(function () use ($question, $form, $questionId) {
            // 一時的なヒントを連想配列として作成
            $tempHintsOriginallyNoImage = $this->prepareTempHintsOriginallyNoImage($form);
            $tempHintsOriginallyWithImage = $this->prepareTempHintsOriginallyWithImage($form);
            // 既存のヒントをいったん全て削除
            Hint::where('question_id', $questionId)->delete();

            // 既存画像のなかったヒントの更新(再作成)
            $this->restoreHintsOriginallyNoImage(
                $question,
                array_keys($tempHintsOriginallyNoImage),
                array_column($tempHintsOriginallyNoImage, 'hint_text'),
                array_column($tempHintsOriginallyNoImage, 'hint_images'),
            );

            // 既存画像のあったヒントの更新(再作成)
            $this->restoreHintsOriginallyWithImage(
                $question,
                array_keys($tempHintsOriginallyWithImage),
                array_column($tempHintsOriginallyWithImage, 'hint_text'),
                array_column($tempHintsOriginallyWithImage, 'hint_image_ids'),
                array_column($tempHintsOriginallyWithImage, 'hint_new_images'),
            );

            // 新規ヒントの保存
            $this->store($question, $form);
        });
    }
}
