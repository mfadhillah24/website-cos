@extends('layouts.admin')

@section('title', 'Kategori Artikel')
@section('page_title', 'Kategori Artikel')
@section('breadcrumb', 'Publikasi / Kategori Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Kategori</h2>
        @can('manage_news')
        <a href="{{ route('admin.article-categories.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kategori
        </a>
        @endcan
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Jml Artikel</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="font-semibold">{{ $category->name }}</td>
                        <td class="text-muted text-sm">{{ $category->slug }}</td>
                        <td class="text-sm">{{ Str::limit($category->description, 50, '...') }}</td>
                        <td><span class="badge badge-blue">{{ $category->articles_count }}</span></td>
                        <td>
                            <div class="flex justify-end gap-2">
                                @can('manage_news')
                                <a href="{{ route('admin.article-categories.edit', $category) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.article-categories.destroy', $category) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada kategori artikel.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
