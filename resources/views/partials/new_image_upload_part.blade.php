@php
    $computed_field_name = isset($index) ? $field_name . '[' . $index . ']' : $field_name;
    $computed_file_element_id = 'file_element_' . $computed_field_name;
@endphp

<div class="drop_area_{{ $field_name }} drop_area">
    <p>ここに画像をドロップ、または</p>
    <input type="file"
    name="{{ $computed_field_name }}[]"
    id="{{ $computed_file_element_id }}"
    multiple accept="image/*">
    <label class="button" for="{{ $computed_file_element_id }}"></label>
</div>
