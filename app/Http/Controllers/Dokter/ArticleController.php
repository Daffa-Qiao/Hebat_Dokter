<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', Auth::id())->latest()->get();
        return view('dokter.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('dokter.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'published' => 'boolean',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create([
            'user_id'        => Auth::id(),
            'title'          => $validated['title'],
            'content'        => $validated['content'],
            'specialization' => Auth::user()->specialization,
            'thumbnail'      => $path,
            'published'      => $request->boolean('published', false),
        ]);

        return redirect()->route('dokter.articles.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        abort_unless($article->user_id === Auth::id(), 403);
        return view('dokter.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        abort_unless($article->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'published' => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'thumbnail' => $validated['thumbnail'] ?? $article->thumbnail,
            'published' => $request->boolean('published', false),
        ]);

        return redirect()->route('dokter.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        abort_unless($article->user_id === Auth::id(), 403);
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return redirect()->route('dokter.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
