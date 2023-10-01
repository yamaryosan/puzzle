<!-- 画像 -->
@if (count($question_images) > 0)
    <p>画像</p>
    @foreach ($question_images as $question_image)
    <img src="{{ asset('storage/' . $question_image->path) }}" alt="画像" class="resized_image">
    @endforeach
@endif
