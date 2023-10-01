<div id="hint_container">
    @csrf
    <!-- 既存のヒント -->
    @include('partials.question_edit.hint.existing_hint_section')
    <!-- 新規のヒント(JSで以下の入力欄を増減) -->
</div>
<button type="button" id="add_hint">+</button>
<button type="button" id="remove_hint">-</button>
