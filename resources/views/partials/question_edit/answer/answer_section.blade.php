<div id="answer_container">
    @csrf
    <!-- 既存の正答 -->
    @include('partials.question_edit.answer.existing_answer_section')
    <!-- 新規の正答(JSで以下の入力欄を増減) -->
</div>
<button type="button" id="add_answer">+</button>
<button type="button" id="remove_answer">-</button>

