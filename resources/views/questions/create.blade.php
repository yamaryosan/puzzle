@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/image_drop_form.css') }}">
</head>
<script>
    // 以前の入力内容(ヒント、正答)を復元
    const oldHints = @json(old('hint_text', []));
    const oldAnswers = @json(old('new_answer_text', []));
</script>
<form action="{{route('questions.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- エラーセクション -->
    @include('partials.error_section', ['errors' => $errors])
    <!-- タイトルセクション -->
    @include('partials.question_create.title_section')
    <!-- 問題文セクション -->
    @include('partials.question_create.content_section')
    <!-- 問題文用画像セクション -->
    @include('partials.question_create.question_image_section')
    <!-- ジャンルセクション -->
    @include('partials.question_create.genre_section', ['existingGenres' => $existingGenres])
    <!-- ヒントセクション -->
    @include('partials.question_create.hint_section')
    <!-- パターンセクション -->
    @include('partials.question_create.pattern_section')
    <!-- 正答セクション -->
    @include('partials.question_create.answer_section')
    <button type="submit">投稿</button>
</form>
@endsection

@vite([
    'resources/js/answer_handler.js',
    'resources/js/genre_handler.js',
    'resources/js/hint_handler.js',
    'resources/js/hint_recoverer.js',
    'resources/js/answer_recoverer.js',
    ])
