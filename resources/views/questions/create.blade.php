@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/image_drop_form.css') }}">
</head>
<script>
    // 以前の入力内容(ヒント、正答、ジャンル)を復元
    const oldHints = @json(old('new_hint_text', []));
    const oldAnswers = @json(old('new_answer_text', []));
    const oldGenreText = @json(old('new_genre_text', []));
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
    'resources/js/newHintBlock.js',
    'resources/js/newAnswerBlock.js',
    'resources/js/newGenreBlock.js',
    ])
