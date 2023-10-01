<p>パターン</p>
@foreach($question->patterns as $pattern)
    <p>{{ $pattern->title }}</p>
    <p>{{ $pattern->content }}</p>
    @foreach($pattern->images as $image)
        <img src="{{ asset('storage/' . $image->path) }}" alt="パターン画像" class="resized_image">
    @endforeach
@endforeach
