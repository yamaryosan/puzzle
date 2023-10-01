@foreach($questions as $question)
<p>
    <a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a>
    <!-- 本文が100文字以上の場合は100文字まで表示し、それ以降は...と表示する -->
    <p>{{ mb_strlen($question->content) > 100 ? mb_substr($question->content, 0, 100).'...' : $question->content }}</p>
    <a href="{{ route('questions.edit', $question->id) }}">編集</a>
    <form action="{{ route('questions.destroy', $question->id) }}" method="get" onsubmit="return confirm('本当に削除しますか？')">
        @csrf
        <input type="submit" value="削除">
    </form>
</p>
@endforeach
