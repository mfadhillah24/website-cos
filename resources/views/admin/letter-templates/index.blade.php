@extends('layouts.admin')

@section('title', 'Template Surat')
@section('page_title', 'Template Surat')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:1.25rem;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" style="margin-bottom:1.25rem;">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem;">
        <h2 class="card-title" style="margin:0;">Daftar Template Surat</h2>
        <a href="{{ route('admin.letter-templates.create') }}" class="btn btn-primary">
            + Tambah Template
        </a>
    </div>

    <div style="padding:0 1.25rem 1.25rem;">
        @forelse ($templates as $letter_template)

            @php
                $ext = strtolower($letter_template->file_extension ?? '');
                $isPdf = $ext === 'pdf';
                $isWord = in_array($ext, ['doc','docx']);
                $fileLabel = $isPdf ? 'PDF' : ($isWord ? strtoupper($ext) : '');
                $fileSize = $letter_template->file_size
                    ? round($letter_template->file_size / 1024, 1) . ' KB'
                    : null;
            @endphp

            <div style="display:flex; align-items:flex-start; gap:1rem; padding:1rem 0; border-bottom:1px solid #f1f3f5;">

                {{-- Icon --}}
                <div style="flex-shrink:0; width:40px; height:40px; background:{{ $isPdf ? '#fff1f0' : '#f0f4ff' }}; border-radius:10px; display:flex; align-items:center; justify-content:center; color:{{ $isPdf ? '#cf1322' : '#2563eb' }};">
                    <x-lucide-file-text style="width:20px;height:20px;" />
                </div>

                {{-- Info --}}
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:.95rem; color:#111827; word-break:break-word;">
                        {{ $letter_template->name }}
                    </div>
                    @if($letter_template->description)
                        <div style="font-size:.82rem; color:#6b7280; margin-top:.15rem; word-break:break-word;">
                            {{ Str::limit($letter_template->description, 120) }}
                        </div>
                    @endif

                    {{-- File badge + size --}}
                    @if($letter_template->file_path)
                        <div style="margin-top:.4rem; display:flex; align-items:center; gap:.5rem; flex-wrap:wrap;">
                            <span style="display:inline-block; padding:.15rem .55rem; border-radius:6px; font-size:.72rem; font-weight:700; letter-spacing:.05em; background:{{ $isPdf ? '#fff1f0' : '#eff6ff' }}; color:{{ $isPdf ? '#cf1322' : '#1d4ed8' }};">
                                {{ $fileLabel }}
                            </span>
                            @if($fileSize)
                                <span style="font-size:.75rem; color:#9ca3af;">{{ $fileSize }}</span>
                            @endif
                            @if($letter_template->file_name)
                                <span style="font-size:.75rem; color:#9ca3af; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:260px;">
                                    {{ $letter_template->file_name }}
                                </span>
                            @endif
                        </div>
                    @else
                        <div style="margin-top:.4rem;">
                            <span style="font-size:.78rem; color:#9ca3af;">Belum ada file</span>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div style="display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; flex-shrink:0;">
                    @if($letter_template->file_path)
                        @if($isPdf)
                            <a href="{{ Storage::url($letter_template->file_path) }}" target="_blank"
                               class="btn btn-secondary btn-sm">Lihat</a>
                        @endif
                        <a href="{{ route('admin.letter-templates.download', $letter_template) }}"
                           class="btn btn-secondary btn-sm">Download</a>
                    @endif
                    <a href="{{ route('admin.letter-templates.edit', $letter_template) }}"
                       class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.letter-templates.destroy', $letter_template) }}"
                          style="display:inline;" onsubmit="return confirm('Hapus template ini beserta filenya?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>

            </div>

        @empty
            <div style="padding:2.5rem; text-align:center; color:#9ca3af;">
                Belum ada template surat.
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($templates->hasPages())
            <div style="margin-top:1rem;">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>

@endsection