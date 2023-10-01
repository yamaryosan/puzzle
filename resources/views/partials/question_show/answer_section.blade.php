<p>正答</p>
@foreach ($answers as $answer)
    <p>{{ $answer->answer }}</p>
    <!-- 正答画像 -->
    @if(count($answer->images) > 0)
        @foreach ($answer->images as $image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="正答画像" class="resized_image">
        @endforeach
    @else
        <p>この正答には画像がありません。</p>
    @endif
@endforeach
