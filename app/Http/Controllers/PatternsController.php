<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pattern;

use App\Services\ImageService;
use App\Services\PatternService;

class PatternsController extends Controller
{
    public function __construct(
        ImageService $imageService,
        PatternService $patternService
    )
    {
        $this->imageService = $imageService;
        $this->patternService = $patternService;
    }

    /**
     * インデックスページ用
     */
    public function index(Request $request)
    {
        $patterns = Pattern::all();
        return view('patterns.index', compact('patterns'));
    }

    /**
     * パターン作成ページ用
     */
    public function create()
    {
        return view('patterns.create');
    }

    /**
     * パターン作成処理用
     */
    public function store(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        $this->patternService->store($form);
        return redirect(route('patterns.index'));
    }

    /**
     * パターン詳細ページ用
     * @param string $id
     */
    public function show(string $id)
    {
        $pattern = Pattern::find($id);
        $images = $patterns->images;
        return view('patterns.show', compact('pattern', 'images'));
    }

    /**
     * パターン編集ページ用
     * @param string $id
     */
    public function edit(string $id)
    {
        $pattern = Pattern::find($id);
        $images = $pattern->images;
        return view('patterns.edit', compact('pattern', 'images'));
    }

    /**
     * パターン編集処理用
     */
    public function update(Request $request, string $id)
    {
        $form = $request->all();
        unset($form['_token']);
        $this->patternService->update($form, $id);
        return redirect(route('patterns.show', ['id' => $id]));
    }

    /**
     * パターン削除処理用
     */
    public function destroy(string $id)
    {
        $pattern = Pattern::find($id);
        $pattern->delete();
        return redirect(route('patterns.index'));
    }
}
