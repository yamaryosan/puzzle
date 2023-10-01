@extends('layouts.app')

@section('content')
    <!-- タイトルセクション -->
    @include('partials.question_show.title_section')
    <!-- 問題文セクション -->
    @include('partials.question_show.content_section')
    <!-- 問題文用画像セクション -->
    @include('partials.question_show.question_image_section')
    <!-- ジャンルセクション -->
    @include('partials.question_show.genre_section')
    <!-- ヒントセクション -->
    @include('partials.question_show.hint_section')
    <!-- パターンセクション -->
    @include('partials.question_show.pattern_section')
    <!-- 正答セクション -->
    @include('partials.question_show.answer_section')
    <!-- 編集ボタン -->
    <form action="/questions/{{ $question->id }}/edit" method="get">
        @csrf
        <input type="submit" value="編集">
    </form>
    <form action="{{ route('questions.destroy', $question->id) }}" method="get" onsubmit="return confirm('本当に削除しますか？')">
        @csrf
        <input type="submit" value="削除">
    </form>
@endsection
