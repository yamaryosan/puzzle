<div id="hint_container">
    <div id="existing_hint_container">
        <!-- 既存のヒント -->
        @include('partials.question_edit.hint.existing_hint_section')
    </div>
    <div id="new_hint_container">
        <p>新規ヒント</p>
        <!-- 新規のヒント(JSで以下の入力欄を増減) -->
    </div>
</div>
<button type="button" id="add_hint">+</button>
<button type="button" id="remove_hint">-</button>
