<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Hint;
use App\Models\Answer;
use App\Models\Genre;
use App\Models\Pattern;
use App\Models\Image;

use App\Services\QuestionService;

class QuestionsController extends Controller
{
    public function __construct(
        QuestionService $questionService
    )
    {
        $this->questionService = $questionService;
    }

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
        // 既存ジャンルを取得
        $existingGenres = Genre::all();
        // パターンを取得
        $patterns = Pattern::all();
        return view('questions.create', compact('existingGenres', 'patterns'));
    }

    /**
     * 問題作成処理用
     */
    public function store(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        $this->questionService->store($form);
        return redirect(route('questions.index'));
    }

    /**
     * 問題詳細ページ用
     * @param string $id
     */
    public function show(string $id)
    {
        // 表示に必要なデータを取得
        $question = Question::find($id);
        $questionImages = $question->images;
        dd($questionImages);
        $genres = $question->genres;
        $hints = Hint::where('question_id', $id)->with('images')->get();
        $patterns = $question->patterns;
        $answers = Answer::where('question_id', $id)->with('images')->get();

        $data = [
            'id' => $id,
            'question' => $question,
            'question_images' => $questionImages,
            'genres' => $genres,
            'hints' => $hints,
            'patterns' => $patterns,
            'answers' => $answers,
        ];

        return view('questions.show', $data);
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
