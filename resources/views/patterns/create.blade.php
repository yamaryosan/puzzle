@extends('layouts.app')

@section('content')
<form action="{{route('patterns.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- エラーセクション -->
    @include('partials.error_section')
    <!-- パターンセクション -->
    @include('partials.pattern_create.pattern_section')
    <button type="submit">登録</button>
</form>
@endsection
