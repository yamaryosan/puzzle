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
}
