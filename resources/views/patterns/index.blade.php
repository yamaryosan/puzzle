@extends('layouts.app')

@section('content')
    <h1>パターン一覧</h1>
    @if (count($patterns) === 0)
        <p>パターンがありません。最初のパターンを<a href="{{ route('patterns.create' )}}">ここ</a>から作ってみましょう。</p>
    @endif
    <ul>
        @foreach ($patterns as $pattern)
            <li>
                <a href="{{route('patterns.show', $pattern)}}">{{$pattern->title}}</a>
                <a href="{{ route('patterns.edit', $pattern->id) }}">編集</a>
                <p>{{$pattern->content}}</p>
                <!-- パターン削除ボタン -->
                <form action="{{ route(patterns.destroy) }}" method="get" onsubmit="return confirm('本当に削除しますか？')">
                    @csrf
                    <input type="submit" value="削除">
                </form>
                @foreach($pattern->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="パターン画像" class="resized_image">
                @endforeach
            </li>
        @endforeach
    </ul>
@endsection
