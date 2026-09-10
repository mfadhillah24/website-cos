@extends('layouts.admin')

@section('title', 'Artikel & Berita')
@section('page_title', 'Artikel & Berita')
@section('breadcrumb', 'Publikasi / Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Artikel</h2>
        @can('manage_news')
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tulis Artikel
        </a>
        @endcan
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Publikasi</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ Str::limit($article->title, 60) }}</div>
                            <div class="text-xs text-muted">Oleh: {{ $article->author->name ?? 'Sistem' }}</div>
                        </td>
                        <td>
                            <span class="badge badge-gray">{{ $article->category->name }}</span>
                        </td>
                        <td>
                            @if($article->status === 'published')
                                <span class="badge badge-green">Dipublikasi</span>
                            @else
                                <span class="badge badge-gray">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-sm">
                                {{ $article->published_at ? $article->published_at->format('d M Y, H:i') : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-secondary btn-sm">Lihat</a>
                                @can('manage_news')
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus artikel ini?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada artikel.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
