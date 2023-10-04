<div id="genre_container">
    <!-- 既チェックジャンル -->
    @foreach($checked_genres as $checked_genre)
        <input type="checkbox" name="existing_genre_ids_checked[]" value="{{ $checked_genre->id }}" id="existing_genre_ids_checked[{{ $checked_genre->id }}]" checked>
        <label for="existing_genre_ids_checked[{{ $checked_genre->id }}]">{{ $checked_genre->genre }}</label>
    @endforeach
    <!-- 既存だが未チェックジャンル -->
    @foreach($remained_genres as $remained_genre)
        <input type="checkbox" name="existing_genre_ids_checked[]" value="{{ $remained_genre->id }}" id="existing_genre_ids_checked[{{ $remained_genre->id }}]">
        <label for="existing_genre_ids_checked[{{ $remained_genre->id }}]">{{ $remained_genre->genre }}</label>
    @endforeach
    <!-- 新規ジャンル追加 -->
    <div id="new_genre_container">
        <p>新規ジャンル</p>
        @if (count($checked_genres) == 0)
            <div class="new_genre_block">
                <input type="text" name="new_genre_text[0]" placeholder="問題のジャンルを入力">
            </div>
        @endif
    </div>
</div>
<button type="button" id="add_genre">+</button>
<button type="button" id="remove_genre">-</button>
