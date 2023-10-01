@php
$answerLoop = 0; // 正答の順番を示す変数
$imageFormOrderLoop = 0; // 画像投稿フォームの順番を示す変数
@endphp

<p>既存正答</p>
@foreach($answers as $answer)
    <div class="existing_answer_block">
        @if (count($answer->images) == 0)
            <!-- 画像がない場合、新規画像アップロード欄を表示 -->
            <textarea name="answer_text_originally_no_image[{{ $answerLoop }}]">{{$answer->answer}}</textarea>
            <button type="button" class="delete_answer_button">正答削除</button>
            <p>画像はありません</p>
            <input type="hidden" name="answer_ids_originally_no_image[{{ $answerLoop }}][]" value="{{ $answer->id }}">
            @include('partials.new_image_upload_part', ['field_name' => 'answer_images_originally_no_image', 'index' => $answerLoop])
        @else
            <!-- 画像がある場合の正答欄 -->
            <textarea name="answer_text_originally_with_image[{{ $answerLoop }}]">{{$answer->answer}}</textarea>
            <button type="button" class="delete_answer_button">正答削除</button>
            <input type="hidden" name="answer_ids_originally_with_image[{{ $answerLoop }}][]" value="{{ $answer->id }}">

            <!-- 画像がある場合の新規画像アップロード欄 -->
            @php
            $imageFormOrderLoop = 0;
            @endphp
            @include('partials.question_edit.common.insert_new_image_between_existing_images',
            ['field_name' => 'answer_new_images_originally_with_image',
            'loop' => $answerLoop,
            'imageFormOrderLoop' => $imageFormOrderLoop
            ])
            @php
            $imageFormOrderLoop++;
            @endphp
            @foreach($answer->images as $image)
                <!-- 画像がある場合の画像欄 -->
                <div class="existing_answer_image_block">
                    <button type="button" class="delete_image_button">画像削除</button>
                    <p><img src="{{ asset('storage/' . $image->path) }}" class="resized_image" alt="画像"></p>
                    <input type="hidden" name="answer_image_ids_originally_with_image[{{ $answerLoop }}][]" value="{{ $image->id }}">
                    @include('partials.question_edit.common.insert_new_image_between_existing_images',
                    ['field_name' => 'answer_new_images_originally_with_image',
                    'loop' => $answerLoop,
                    'imageFormOrderLoop' => $imageFormOrderLoop])
                </div>
                @php
                $imageFormOrderLoop++;
                @endphp
            @endforeach
        @endif
    </div>
    @php
    $answerLoop++;
    @endphp
@endforeach
