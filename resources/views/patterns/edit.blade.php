@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/image_drop_form.css') }}">
</head>
<script>
    // 以前の入力内容(ヒント、正答)を復元
    const oldHints = @json(old('hints', []));
    const oldAnswers = @json(old('answers', []));
</script>

<form action="{{ route('patterns.update', $pattern->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- タイトルセクション -->
    @include('partials.pattern_edit.title_section')
    <!-- 本文セクション -->
    @include('partials.pattern_edit.content_section')
    <!-- 画像セクション -->
    @include('partials.pattern_edit.image_section')
    <button type="submit">投稿</button>
</form>
@endsection
