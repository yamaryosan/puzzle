<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * インデックスページ
     */
    public function index(Request $request)
    {
        $questions = Question::all();
        return view('questions.index');
    }
}
