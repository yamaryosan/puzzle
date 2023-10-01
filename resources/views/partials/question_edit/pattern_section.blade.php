<div id="pattern_container">
    <p>パターン</p>
    <!-- 既チェックパターン -->
    @foreach($checked_patterns as $checked_pattern)
        <input type="checkbox" name="pattern_ids[]" id="pattern_{{ $checked_pattern->id }}" value="{{ $checked_pattern->id}}" checked>
        <label for="pattern_{{ $checked_pattern->id }}">{{ $checked_pattern->title }}</label>
    @endforeach
    <!-- 未チェックパターン -->
    @foreach($remained_patterns as $remained_pattern)
        <input type="checkbox" name="pattern_ids[]" id="pattern_{{ $remained_pattern->id }}" value="{{ $remained_pattern->id}}">
        <label for="pattern_{{ $remained_pattern->id }}">{{ $remained_pattern->title }}</label>
    @endforeach
</div>
