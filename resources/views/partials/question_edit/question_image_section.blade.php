<div id="question_images_container">
    <p>画像</p>
    @if (count($question_images) == 0)
        <p>画像はありません</p>
        @include('partials.new_image_upload_part', ['field_name' => 'new_question_images', 'index' => 0])
    @else
        <div id="existing_images_container">
            @include('partials.new_image_upload_part', ['field_name' => 'new_question_images', 'index' => 0])
            @foreach ($question_images as $question_image)
                    <div class="existing_question_image_block">
                        <button type="button" class="delete_image_button">削除</button>
                        <p><img src="{{ asset('storage/' . $question_image->path) }}" class="resized_image" alt="画像"></p>
                        <input type="hidden" name="existing_question_image_ids[{{ $loop->iteration - 1 }}]" value="{{ $question_image->id }}">
                        @include('partials.new_image_upload_part', ['field_name' => 'new_question_images', 'index' => $loop->iteration])
                    </div>
            @endforeach
        </div>
    @endif
</div>
