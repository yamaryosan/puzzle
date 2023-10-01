<div id="genre_container">
    <p>ジャンル</p>
    <!-- 既存ジャンルから追加 -->
    @foreach($existingGenres as $existingGenre)
        <!-- チェックボックス -->
        <input type="checkbox" name="existing_genre_ids_checked[]" id="existing_genre_ids_checked[{{ $existingGenre->id }}]" value="{{ $existingGenre->id }}">
        <label for="existing_genre_ids_checked[{{ $existingGenre->id }}]">{{ $existingGenre->genre }}</label>
    @endforeach
    <!-- 新規ジャンル追加 -->
    <div id="new_genre_texts" required>
        <input type="text" name="new_genre_texts[]" placeholder="問題のジャンルを入力">
    </div>
</div>
<button type="button" id="add_genre">+</button>
<button type="button" id="remove_genre">-</button>
