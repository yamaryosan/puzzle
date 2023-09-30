@extends('layouts.app')

@section('content')
    <h1>問題一覧</h1>
    {{ $questions->links() }} <!-- ページネーションのリンク -->
@endsection
