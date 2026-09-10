<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_news');
        $categories = ArticleCategory::withCount('articles')->get();
        return view('admin.article_categories.index', compact('categories'));
    }

    public function create(): View
    {
        $this->authorize('manage_news');
        return view('admin.article_categories.create');
    }

    public function store(StoreArticleCategoryRequest $request): RedirectResponse
    {
        ArticleCategory::create($request->validated());
        return redirect()->route('admin.article-categories.index')->with('success', 'Kategori artikel berhasil ditambahkan.');
    }

    public function edit(ArticleCategory $articleCategory): View
    {
        $this->authorize('manage_news');
        return view('admin.article_categories.edit', compact('articleCategory'));
    }

    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory): RedirectResponse
    {
        $articleCategory->update($request->validated());
        return redirect()->route('admin.article-categories.index')->with('success', 'Kategori artikel berhasil diperbarui.');
    }

    public function destroy(ArticleCategory $articleCategory): RedirectResponse
    {
        $this->authorize('manage_news');
        if ($articleCategory->articles()->count() > 0) {
            return back()->with('error', 'Kategori ini tidak bisa dihapus karena memiliki artikel.');
        }
        $articleCategory->delete();
        return redirect()->route('admin.article-categories.index')->with('success', 'Kategori artikel berhasil dihapus.');
    }
}
