<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $specialization = $request->get('specialization');
        $search = $request->get('search');

        $articles = Article::with('author')
            ->where('published', true)
            ->when($specialization, fn($q) => $q->where('specialization', $specialization))
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('content', 'ilike', "%{$search}%");
            }))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $specializations = Article::where('published', true)
            ->whereNotNull('specialization')
            ->distinct()
            ->pluck('specialization');

        return view('articles.index', compact('articles', 'specializations', 'specialization', 'search'));
    }

    public function show(Article $article)
    {
        abort_unless($article->published, 404);
        $article->load('author');
        return view('articles.show', compact('article'));
    }

    public function create() { }
    public function store(Request $request) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id)
    {
        //
    }
}
