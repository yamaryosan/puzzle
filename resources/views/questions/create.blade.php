@extends('layouts.app')

@section('content')

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
    @include('partials.question_create.genre_section')
    <!-- ヒントセクション -->
    @include('partials.question_create.hint_section')
    <!-- パターンセクション -->
    @include('partials.question_create.pattern_section')
    <!-- 正答セクション -->
    @include('partials.question_create.answer_section')
    <button type="submit">投稿</button>
</form>
@endsection
