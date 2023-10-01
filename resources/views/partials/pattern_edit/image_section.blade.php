<div id="images_container">
    <p>画像</p>
    @if (count($images) == 0)
        <p>画像はありません</p>
        @include('partials.new_image_upload_part', ['field_name' => 'new_images', 'index' => 0])
    @else
        <div id="existing_images_container">
            @include('partials.new_image_upload_part', ['field_name' => 'new_images', 'index' => 0])
            @foreach ($images as $image)
                    <div class="existing_image_block">
                        <button type="button" class="delete_image_button">削除</button>
                        <p><img src="{{ asset('storage/' . $image->path) }}" class="resized_image" alt="画像"></p>
                        <input type="hidden" name="existing_image_ids[{{ $loop->iteration - 1 }}]" value="{{ $image->id }}">
                        @include('partials.new_image_upload_part', ['field_name' => 'new_images', 'index' => $loop->iteration])
                    </div>
            @endforeach
        </div>
    @endif
</div>
