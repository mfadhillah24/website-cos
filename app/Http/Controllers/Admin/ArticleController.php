<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_news');
        $articles = Article::with(['category', 'author'])->orderBy('created_at', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $this->authorize('manage_news');
        $categories = ArticleCategory::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = Auth::id();
        // Slug dibuat otomatis oleh model (Article::boot → creating event)
        // tanpa timestamp, berdasarkan judul saja.

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        // Single thumbnail upload fallback
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/articles'), $filename);
            $data['thumbnail'] = 'articles/' . $filename;
        }

        $article = Article::create($data);

        // Process Gallery Images
        if ($request->hasFile('gallery_images')) {
            $coverIndex = $request->input('cover_image_index', 0);
            $captions = $request->input('gallery_captions', []);

            foreach ($request->file('gallery_images') as $index => $file) {
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/articles/gallery'), $filename);
                $path = 'articles/gallery/' . $filename;
                $isCover = ($index == $coverIndex);

                ArticleImage::create([
                    'article_id' => $article->id,
                    'image_path' => $path,
                    'is_cover' => $isCover,
                    'caption' => $captions[$index] ?? null,
                    'sort_order' => $index,
                ]);

                if ($isCover) {
                    $article->update(['thumbnail' => $path]);
                }
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(Article $article): View
    {
        $this->authorize('view_news');
        $article->load(['category', 'author', 'images']);
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article): View
    {
        $this->authorize('manage_news');
        $categories = ArticleCategory::all();
        $article->load('images');
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        // Perbarui slug ketika judul berubah (model juga menanganinya via
        // updating event, tetapi kita set eksplisit agar $data konsisten)
        if (isset($data['title']) && $data['title'] !== $article->title) {
            $data['slug'] = \App\Models\Article::generateUniqueSlug($data['title'], $article->id);
        }

        if ($data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            // Optional: delete old thumbnail if it was NOT part of gallery
            // To be safe, we just update the path.
            $file = $request->file('thumbnail');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/articles'), $filename);
            $data['thumbnail'] = 'articles/' . $filename;
        }

        $article->update($data);

        // Handle deleted images
        if ($request->has('deleted_images')) {
            $imagesToDelete = ArticleImage::where('article_id', $article->id)
                ->whereIn('id', $request->input('deleted_images'))
                ->get();
            
            foreach ($imagesToDelete as $img) {
                \Illuminate\Support\Facades\File::delete(public_path('images/' . $img->image_path));
                $img->delete();
            }
        }

        // Handle existing captions
        if ($request->has('existing_captions')) {
            foreach ($request->input('existing_captions') as $id => $caption) {
                ArticleImage::where('id', $id)->where('article_id', $article->id)->update(['caption' => $caption]);
            }
        }

        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            $coverIndex = $request->input('cover_image_index');
            $captions = $request->input('gallery_captions', []);
            $maxSort = ArticleImage::where('article_id', $article->id)->max('sort_order') ?? -1;

            foreach ($request->file('gallery_images') as $index => $file) {
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/articles/gallery'), $filename);
                $path = 'articles/gallery/' . $filename;
                $isCover = ($index == $coverIndex); // Note: using loose comparison
                $maxSort++;

                $newImage = ArticleImage::create([
                    'article_id' => $article->id,
                    'image_path' => $path,
                    'is_cover' => $isCover,
                    'caption' => $captions[$index] ?? null,
                    'sort_order' => $maxSort,
                ]);

                if ($isCover) {
                    // Reset all other covers
                    ArticleImage::where('article_id', $article->id)->where('id', '!=', $newImage->id)->update(['is_cover' => false]);
                    $article->update(['thumbnail' => $path]);
                }
            }
        }

        // Handle existing cover image change
        if ($request->filled('cover_image_id')) {
            $coverId = $request->input('cover_image_id');
            ArticleImage::where('article_id', $article->id)->update(['is_cover' => false]);
            $newCover = ArticleImage::where('article_id', $article->id)->where('id', $coverId)->first();
            if ($newCover) {
                $newCover->update(['is_cover' => true]);
                $article->update(['thumbnail' => $newCover->image_path]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorize('manage_news');
        
        $images = ArticleImage::where('article_id', $article->id)->get();
        foreach ($images as $img) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $img->image_path));
            $img->delete();
        }

        if ($article->thumbnail) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $article->thumbnail));
        }
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        $this->authorize('manage_news');
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/articles/inline'), $filename);
            $path = 'articles/inline/' . $filename;
            return response()->json(['location' => asset('images/' . $path)]);
        }

        return response()->json(['error' => 'File not found'], 400);
    }
}
