<ul>
    <li><a href="{{ route('questions.index') }}">問題一覧</a></li>
    <li><a href="{{ route('questions.create') }}">問題追加</a></li>
    <li><a href="{{ route('patterns.index') }}">パターン一覧</a></li>
    <li><a href="{{ route('patterns.create') }}">パターン追加</a></li>
</ul>

<!-- ジャンル一覧 -->
@include('partials.sidebar.genre_list')


<!-- データ全削除 -->
@include('partials.sidebar.delete_all')
