<div id="answer_container">
    <div id="existing_answer_container">
        <!-- 既存の正答 -->
        @include('partials.question_edit.answer.existing_answer_section')
    </div>
    <div id="new_answer_container">
        <p>新規正答</p>
        <!-- 新規の正答(JSで入力欄を増減) -->
    </div>
</div>
<button type="button" id="add_answer">+</button>
<button type="button" id="remove_answer">-</button>
