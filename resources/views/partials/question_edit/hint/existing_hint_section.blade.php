@php
$hintLoop = 0; // ヒントの順番を示す変数
$imageFormOrderLoop = 0; // 画像投稿フォームの順番を示す変数
@endphp

<p>既存ヒント</p>
@foreach($hints as $hint)
    <div class="existing_hint_block">
        @if (count($hint->images) == 0)
            <!-- 画像がない場合、新規画像アップロード欄を表示 -->
            <textarea name="hint_text_originally_no_image[{{ $hintLoop }}]">{{$hint->hint}}</textarea>
            <button type="button" class="delete_hint_button">ヒント削除</button>
            <p>画像はありません</p>
            <input type="hidden" name="hint_ids_originally_no_image[{{ $hintLoop }}][]" value="{{ $hint->id }}">
            @include('partials.new_image_upload_part', ['field_name' => 'hint_images_originally_no_image', 'index' => $hintLoop])
        @else
            <!-- 画像がある場合のヒント欄 -->
            <textarea name="hint_text_originally_with_image[{{ $hintLoop }}]">{{$hint->hint}}</textarea>
            <button type="button" class="delete_hint_button">ヒント削除</button>
            <input type="hidden" name="hint_ids_originally_with_image[{{ $hintLoop }}][]" value="{{ $hint->id }}">

            <!-- 画像がある場合の新規画像アップロード欄 -->
            @php
            $imageFormOrderLoop = 0;
            @endphp
            @include('partials.question_edit.common.insert_new_image_between_existing_images',
            ['field_name' => 'hint_new_images_originally_with_image',
            'loop' => $HintLoop,
            'imageFormOrderLoop' => $imageFormOrderLoop
            ])
            @php
            $imageFormOrderLoop++;
            @endphp
            @foreach($hint->images as $image)
                <!-- 画像がある場合の画像欄 -->
                <div class="existing_hint_image_block">
                    <button type="button" class="delete_image_button">画像削除</button>
                    <p><img src="{{ asset('storage/' . $image->path) }}" class="resized_image" alt="画像"></p>
                    <input type="hidden" name="hint_image_ids_originally_with_image[{{ $hintLoop }}][]" value="{{ $image->id }}">
                    @include('partials.question_edit.common.insert_new_image_between_existing_images',
                    ['field_name' => 'hint_new_images_originally_with_image',
                    'loop' => $HintLoop,
                    'imageFormOrderLoop' => $imageFormOrderLoop])
                </div>
                @php
                $imageFormOrderLoop++;
                @endphp
            @endforeach
        @endif
    </div>
    @php
    $hintLoop++;
    @endphp
@endforeach
