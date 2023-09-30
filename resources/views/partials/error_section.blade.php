@if($errors->any())
<p>エラー</p>
<ul>
    @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>
@endif
