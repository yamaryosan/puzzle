<div id="answer_container">
    <p>正答</p>
    <div class="answer_block">
        <textarea name="new_answer_text[]" placeholder="正答を入力" required></textarea>
        @include('partials.new_image_upload_part', ['field_name' => 'new_answer_images', 'index' => 0])
    </div>
</div>
<button type="button" id="add_answer">+</button>
<button type="button" id="remove_answer">-</button>
