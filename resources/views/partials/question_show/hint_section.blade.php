@if (count($hints) == 0)
<p>ヒントはありません</p>
@else
<p>ヒント</p>
@foreach ($hints as $hint)
    <p>{{ $hint->hint }}</p>
    <!-- ヒント画像 -->
    @if(count($hint->images) > 0)
        @foreach ($hint->images as $image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="ヒント画像" class="resized_image">
        @endforeach
    @else
        <p>このヒントには画像がありません。</p>
    @endif
@endforeach
@endif
