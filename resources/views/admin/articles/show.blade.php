@extends('layouts.admin')

@section('title', $article->title)
@section('page_title', 'Detail Artikel')
@section('breadcrumb', 'Publikasi / Artikel / ' . $article->title)

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $article->title }}</h2>
                <div class="text-xs text-muted" style="margin-top: 4px;">
                    Oleh: {{ $article->author->name ?? 'Sistem' }} · Kategori: {{ $article->category->name }}
                </div>
            </div>
            <div class="flex gap-2">
                @can('manage_news')
                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-secondary btn-sm">Edit</a>
                @endcan
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if($article->thumbnail)
                <div style="margin-bottom: 24px;">
                    <img src="{{ asset('images/' . $article->thumbnail) }}" style="width: 100%; border-radius: 8px;">
                </div>
            @endif

            <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div style="display:flex; gap:12px;">
                        @if($article->status === 'published')
                            <span class="badge badge-green">Dipublikasi pada {{ $article->published_at ? $article->published_at->format('d M Y, H:i') : '-' }}</span>
                        @else
                            <span class="badge badge-gray">Draft</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($article->excerpt)
                <div style="font-weight: 500; font-size: 16px; line-height: 1.5; margin-bottom: 24px; color: var(--text-color);">
                    {{ $article->excerpt }}
                </div>
            @endif

            <div class="article-content" style="line-height: 1.8;">
                {!! $article->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
