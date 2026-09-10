<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = ArticleCategory::withCount([
            'articles' => fn($q) => $q->where('status', 'published')
        ])->get();

        return view('public.articles.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        abort_if($article->status !== 'published', 404);

        $article->load(['category', 'author', 'images']);

        $related = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('public.articles.show', compact('article', 'related'));
    }
}
