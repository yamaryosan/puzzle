<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

class QuestionsController extends Controller
{
    /**
     * インデックス
     */
    public function index(Request $request)
    {
        $questions = Question::paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * 問題作成ページ用
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * 問題作成処理用
     */
    public function store()
    {
        return redirect(route('questions.index'));
    }

    /**
     * 問題詳細ページ用
     * @param string $id
     */
    public function show(string $id)
    {

    }

    /**
     * 問題編集ページ用
     */
    public function edit(string $id)
    {

    }

    /**
     * 問題編集処理用
     */
    public function update(string $id)
    {

    }

    /**
     * 問題削除処理用
     */
    public function destroy(string $id)
    {

    }
}
