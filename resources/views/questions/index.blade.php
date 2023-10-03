@extends('layouts.app')

@section('content')
    <h1>問題一覧</h1>
    @isset($searchWord)
        <p>検索ワード：{{ $searchWord }} の検索結果 {{ $questions->total() }}件</p>
        @empty($questions->count())
            <p>一致する問題はありませんでした。</p>
        @endempty
        @include('partials.question_index.result_section', ['searchWord' => $searchWord])
    @else
        @empty($questions->count())
            <p>問題がありません。最初の問題を<a href="{{ route('questions.create')}}">ここ</a>から作ってみましょう。</p>
        @endempty
        @include('partials.question_index.result_section', ['searchWord' => ''])
    @endif
    {{ $questions->links() }}
@endsection
