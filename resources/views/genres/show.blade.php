<!-- ジャンルに属する問題一覧 -->
@extends('layouts.app')

@section('content')
<!-- ジャンル変更に成功したらメッセージを表示 -->
@if (session('success'))
    <div class="alert alert_success">
        {{ session('success') }}
    </div>
@endif
<!-- ジャンル名を変更 -->
    <h1>{{ $genre->genre }}の問題一覧</h1>
    <a href="{{ route('genres.edit', $genre->id) }}" class="btn">名前の編集</a>

    <!-- 問題一覧を表示 -->
    <ul>
        @foreach ($genre->questions as $question)
            <li><a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a></li>
        @endforeach
    </ul>
@endsection
