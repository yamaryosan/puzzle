<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Requests\GenreRequest;

class GenresController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('genres.index', compact('genres'));
    }

    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        $questions = $genre->questions;
        return view('genres.show', compact('genre', 'questions'));
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('genres.edit', compact('genre'));
    }

    public function update(GenreRequest $request, $id)
    {
        $form = $request->all();
        unset($form['_token']);
        $genre = Genre::findOrFail($id);
        $genre->update([
            'genre' => $form['genre'],
        ]);

        return redirect()->route('genres.show', $id)->with('message', 'ジャンルを更新しました');
    }
}
