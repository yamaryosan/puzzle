<!-- サイドバー中のジャンル一覧表示部 -->
<p>ジャンル</p>
<ul>
    @foreach ($genres as $genre)
        <!-- ジャンルに属する問題一覧ページへのリンクを表示 -->
        <li><a href="{{ route('genres.show', ['id' => $genre->id]) }}">{{ $genre->genre }}</a></li>
    @endforeach
</ul>
