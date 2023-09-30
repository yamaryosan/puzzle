<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

class QuestionsController extends Controller
{
    /**
     * インデックスページ
     */
    public function index(Request $request)
    {
        $questions = Question::paginate(10);
        return view('questions.index', compact('questions'));
    }
}
