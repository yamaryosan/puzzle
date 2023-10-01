<p>ジャンル</p>
@foreach($question->genres as $genre)
    <p>{{ $genre->genre }}</p>
@endforeach
