<form action="{{ route('questions.deleteAll') }}" method="post" id="delete_all_form">
    @csrf
    <button type="button" class="btn" id="delete_all">データ全削除</button>
</form>

@vite(['resources/js/delete_all_alert.js'])
