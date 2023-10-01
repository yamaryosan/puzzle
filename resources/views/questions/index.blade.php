@extends('layouts.app')

@section('content')
    <h1>問題一覧</h1>
    @include('partials.question_index.result_section')
    {{ $questions->links() }} <!-- ページネーションのリンク -->
@endsection
