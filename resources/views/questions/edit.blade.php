@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/image_drop_form.css') }}">
</head>
<script>
    // 以前の入力内容(ヒント、正答)を復元
    const oldHints = @json(old('new_hint_text', []));
    const oldAnswers = @json(old('new_answer_text', []));
</script>

<form action="{{ route('questions.update', $question->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- エラーセクション -->
    @include('partials.error_section', ['errors' => $errors])
    <!-- タイトルセクション -->
    @include('partials.question_edit.title_section')
    <!-- 問題文セクション -->
    @include('partials.question_edit.content_section')
    <!-- 問題文用画像セクション -->
    @include('partials.question_edit.question_image_section')
    <!-- ジャンルセクション -->
    @include('partials.question_edit.genre_section', ['checked_genres' => $checked_genres, 'remained_genres' => $remained_genres])
    <!-- ヒントセクション -->
    @include('partials.question_edit.hint.hint_section')
    <!-- パターンセクション -->
    @include('partials.question_edit.pattern_section', ['checked_patterns' => $checked_patterns, 'remained_patterns' => $remained_patterns])
    <!-- 正答セクション -->
    @include('partials.question_edit.answer.answer_section')
    <button type="submit">投稿</button>
</form>
@endsection

@vite([
    'resources/js/genre_handler.js',
    'resources/js/newHintBlock.js',
    'resources/js/answer_recoverer.js',
    'resources/js/image_delete.js',
    'resources/js/hint_delete.js',
    'resources/js/answer_delete.js',
    'resources/js/edit_page_answer_handler.js',
    ])
