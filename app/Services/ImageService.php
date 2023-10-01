<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Hint;
use App\Models\Pattern;
use App\Models\Answer;

use Intervention\Image\Facades\Image as ImageIntervention;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function upload($file, string $path)
    {
        // 画像をリサイズ
        $newImage = ImageIntervention::make($file); // 画像をインスタンス化
        $newImage->resize(1000, null, function ($constraint) { // 画像をリサイズ
            $constraint->aspectRatio(); // アスペクト比を維持
        });

        // 一時ファイル用ディレクトリtmpを作成
        if (!file_exists(public_path('storage/tmp'))) {
            mkdir(public_path('storage/tmp'));
        }

        // リサイズした画像を一時ファイルに保存
        $tmpPath = public_path('storage/tmp/') . $file->hashName();
        $newImage->save($tmpPath); // 画像を一時ファイルに保存

        // 一時保存した画像をストレージに移動
        $finalPath = Storage::putFile($path, new File($tmpPath)); // 画像をストレージに保存
        $finalPath = str_replace('public/', '', $finalPath); // 画像のパスからpublic/を削除

        // Imageモデルに情報を保存
        $image = new Image;
        $image->path = $finalPath;

        // 一時ファイルを削除
        unlink($tmpPath);
        return $image;
    }

    public function uploadForQuestion(Question $question, array $files)
    {
        foreach($files as $file) {
            $image = $this->upload($file, 'public/questions'); // 画像をアップロード
            $image->save(); // 画像を保存
            $question->images()->attach($image->id); // 問題と画像を紐付け
        }
    }

    public function uploadForPattern(Pattern $pattern, array $files)
    {
        if (empty($files)) {
            return;
        }
        foreach($files as $file) {
            $image = $this->upload($file, 'public/patterns'); // 画像をアップロード
            $image->save(); // 画像を保存
            $pattern->images()->attach($image->id); // パターンと画像を紐付け
        }
    }

    public function uploadForHint(Hint $hint, array $files)
    {
        if (empty($files)) {
            return;
        }
        foreach($files as $file) {
            $image = $this->upload($file, 'public/hints'); // 画像をアップロード
            $image->save(); // 画像を保存
            $hint->images()->attach($image->id); // ヒントと画像を紐付け
        }
    }

    public function uploadForAnswer(Answer $answer, array $files)
    {
        if (empty($files)) {
            return;
        }
        foreach($files as $file) {
            $image = $this->upload($file, 'public/answers'); // 画像をアップロード
            $image->save(); // 画像を保存
            $answer->images()->attach($image->id); // 正答と画像を紐付け
        }
    }


    /**
     * 既存画像を再度問題に紐づける
     * @param Question $question
     * @param array $existingQuestionImageId
     * @return void
     */
    public function reAttachForQuestion(Question $question, string $existingQuestionImageId)
    {
        $image = Image::find($existingQuestionImageId);
        $question->images()->attach($image->id); // 中間テーブルに保存
    }

    /**
     * 既存画像を再度ヒントに紐づける
     * @param Hint $hint
     * @param array $existingHintImageId
     * @return void
     */
    public function reAttachForHint(Hint $hint, string $existingHintImageId)
    {
        $image = Image::find($existingHintImageId);
        $hint->images()->attach($image->id); // 中間テーブルに保存
    }

    /**
     * 既存画像を再度正答に紐づける
     * @param Answer $answer
     * @param array $existingAnswerImageId
     * @return void
     */
    public function reAttachForAnswer(Answer $answer, string $existingAnswerImageId)
    {
        $image = Image::find($existingAnswerImageId);
        $answer->images()->attach($image->id); // 中間テーブルに保存
    }

    /**
     * 既存画像を再度パターンに紐づける
     * @param Pattern $pattern
     * @param array $existingImageId
     * @return void
     */
    public function reAttachForPattern(Pattern $pattern, string $existingImageId)
    {
        $image = Image::find($existingImageId);
        $pattern->images()->attach($image->id); // 中間テーブルに保存
    }

    /**
     * 2つの配列のキー値の最大値を返す
     * @param array $arrayA
     * @param array $arrayB
     * @return int
     */
    public function getKeyMax(array $arrayA, array $arrayB)
    {
        if (empty($arrayA) && empty($arrayB)) {
            return 0;
        }
        if (empty($arrayA)) {
            return max(array_keys($arrayB));
        }
        if (empty($arrayB)) {
            return max(array_keys($arrayA));
        }
        $maxKeyA = max(array_keys($arrayA));
        $maxKeyB = max(array_keys($arrayB));
        return max($maxKeyA, $maxKeyB);
    }

    /**
     * 画像をアップデートする
     *
     * 既存画像IDタグと新規画像アップロードフォームは
     * 新規→既存→新規…と交互に並んでいる
     * これを交互に問題に紐付ける
     *
     * @param Question $question
     * @param array $existingQuestionImageIds
     * @param array $newQuestionImages
     * @return void
     */
    public function updateForQuestion(
        Question $question,
        array $existingQuestionImageIds,
        array $newQuestionImages)
    {
        $question->images()->detach(); // 中間テーブルから削除
        // dd($existingQuestionImageIds, $newQuestionImages);
        // 既存画像と新規画像のキーを比較し、大きい方を$max_countとする
        $max_count = $this->getKeyMax($existingQuestionImageIds, $newQuestionImages) + 1;
        // dd($existingQuestionImageIds, $newQuestionImages, $max_count);
        // 新規画像と既存画像を交互に問題に紐付ける
        for ($i = 0; $i < $max_count; $i++) {
            // 新規画像
            if (isset($newQuestionImages[$i])) {
                // dd($newQuestionImages[$i]);
                $this->uploadForQuestion($question, $newQuestionImages[$i]);
            }
            // 既存画像
            if (isset($existingQuestionImageIds[$i])) {
                $this->reAttachForQuestion($question, $existingQuestionImageIds[$i]);
            }
        }
    }

    /**
     * パターンの画像をアップデートする
     *
     * 既存画像IDタグと新規画像アップロードフォームは
     * 新規→既存→新規…と交互に並んでいる
     * これを交互に問題に紐付ける
     *
     * @param Pattern $pattern
     * @param array $existingImageIds
     * @param array $newQuestionImages
     * @return void
     */
    public function updateForPattern(
        Pattern $pattern,
        array $existingImageIds,
        array $newImages)
    {
        $pattern->images()->detach(); // 中間テーブルから削除
        // 既存画像と新規画像のキーを比較し、大きい方を$max_countとする
        $max_count = $this->getKeyMax($existingImageIds, $newImages) + 1;
        // 新規画像と既存画像を交互に問題に紐付ける
        for ($i = 0; $i < $max_count; $i++) {
            // 新規画像
            if (isset($newImages[$i])) {
                $this->uploadForPattern($pattern, $newImages[$i]);
            }
            // 既存画像
            if (isset($existingImageIds[$i])) {
                $this->reAttachForPattern($pattern, $existingImageIds[$i]);
            }
        }
    }
}
