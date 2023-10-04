<div id="genre_container">
    <div id="existing_genre_container">
        <p>既存ジャンル</p>
        <!-- 既存ジャンルから追加 -->
        @foreach($existingGenres as $existingGenre)
            <!-- チェックボックス -->
            <input type="checkbox" name="existing_genre_ids_checked[]" id="existing_genre_ids_checked[{{ $existingGenre->id }}]" value="{{ $existingGenre->id }}">
            <label for="existing_genre_ids_checked[{{ $existingGenre->id }}]">{{ $existingGenre->genre }}</label>
        @endforeach
    </div>
    <!-- 新規ジャンル追加 -->
    <div id="new_genre_container">
        <p>新規ジャンル</p>
        @if (count($existingGenres) == 0)
            <div class="new_genre_block">
                <input type="text" name="new_genre_text[0]" placeholder="問題のジャンルを入力">
            </div>
        @endif
    </div>
</div>
<button type="button" id="add_genre">+</button>
<button type="button" id="remove_genre">-</button>
