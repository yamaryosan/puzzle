<!-- ジャンル名を変更 -->
@extends('layouts.app')

@section('content')
    <h2>ジャンル編集</h2>

    <!-- エラーメッセージ -->
    @if($errors->any())
        <p>エラー</p>
        <ul>
            @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('genres.update', $genre->id) }}" method="post">
        @csrf
        @method('put')
        <div class="form_group">
            <label for="genre">ジャンル名:</label>
            <input type="text" name="genre" id="genre" class="form_control" value="{{ old('genre', $genre->genre) }}">
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
@endsection
