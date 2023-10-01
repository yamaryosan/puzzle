@extends('layouts.app')

@section('content')
    <h1>{{$pattern->title}} のパターン</h1>
    <!-- 編集ボタン -->
    <a href="{{ route('patterns.edit', $pattern->id) }}">編集</a>
    <p>{{$pattern->content}}</p>
    <!-- 画像 -->
    @foreach($images as $image)
        <img src="{{ asset('storage/' . $image->path) }}" alt="パターン画像" class="resized_image">
    @endforeach
    <!-- パターンを使った問題の紹介 -->
    <h3>このパターンを使った問題</h3>
    @if (count($pattern->questions) === 0)
        <p>このパターンを使った問題はありません。</p>
    @endif
    @foreach($pattern->questions as $question)
        <a href="{{route('questions.show', ['id' => $question->id])}}">{{$question->title}}</a><br>
    @endforeach
@endsection
