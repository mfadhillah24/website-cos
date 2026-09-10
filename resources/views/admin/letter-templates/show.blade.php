@extends('layouts.admin')

@section('title', 'Detail Template Surat')
@section('page_title', 'Detail Template Surat')

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:1.25rem;">{{ session('success') }}</div>
@endif

<div class="card" style="max-width:720px;">
    <div class="card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem;">
        <h2 class="card-title" style="margin:0;">Detail Template Surat</h2>
        <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.letter-templates.edit', $letter_template) }}" class="btn btn-primary btn-sm">Edit</a>
            <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
    <div class="card-body">

        <div style="display:flex; flex-direction:column; gap:1rem;">

            {{-- Nama --}}
            <div>
                <div style="font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:.25rem;">Nama Template</div>
                <div style="font-size:1.05rem; font-weight:700; color:#111827;">{{ $letter_template->name }}</div>
            </div>

            {{-- Deskripsi --}}
            @if($letter_template->description)
            <div>
                <div style="font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:.25rem;">Deskripsi</div>
                <div style="font-size:.9rem; color:#374151; line-height:1.6;">{{ $letter_template->description }}</div>
            </div>
            @endif

            {{-- File --}}
            <div>
                <div style="font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:.5rem;">File Template</div>

                @if($letter_template->file_path)
                    @php
                        $ext = strtolower($letter_template->file_extension ?? '');
                        $isPdf = $ext === 'pdf';
                        $isWord = in_array($ext, ['doc','docx']);
                        $badgeColor = $isPdf ? '#cf1322' : '#1d4ed8';
                        $badgeBg    = $isPdf ? '#fff1f0' : '#eff6ff';
                        $fileSize   = $letter_template->file_size ? round($letter_template->file_size / 1024, 1) . ' KB' : null;
                    @endphp

                    <div style="padding:1rem; background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                        <div style="flex-shrink:0; width:44px; height:44px; background:{{ $isPdf ? '#fff1f0' : '#eff6ff' }}; border-radius:10px; display:flex; align-items:center; justify-content:center; color:{{ $badgeColor }};">
                            <x-lucide-file-text style="width:22px;height:22px;" />
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:600; color:#111827; word-break:break-all; font-size:.9rem;">
                                {{ $letter_template->file_name ?? basename($letter_template->file_path) }}
                            </div>
                            <div style="display:flex; gap:.5rem; align-items:center; margin-top:.35rem; flex-wrap:wrap;">
                                <span style="padding:.15rem .55rem; border-radius:6px; font-size:.72rem; font-weight:700; background:{{ $badgeBg }}; color:{{ $badgeColor }};">
                                    {{ strtoupper($ext) }}
                                </span>
                                @if($fileSize)
                                    <span style="font-size:.75rem; color:#9ca3af;">{{ $fileSize }}</span>
                                @endif
                                @if($letter_template->mime_type)
                                    <span style="font-size:.75rem; color:#d1d5db;">{{ $letter_template->mime_type }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex; gap:.5rem; flex-wrap:wrap; flex-shrink:0;">
                            @if($isPdf)
                                <a href="{{ Storage::url($letter_template->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                                    Lihat
                                </a>
                            @endif
                            <a href="{{ route('admin.letter-templates.download', $letter_template) }}" class="btn btn-primary btn-sm">
                                Download
                            </a>
                        </div>
                    </div>

                    @if($isWord)
                        <div style="margin-top:.5rem; font-size:.8rem; color:#9ca3af;">
                            Dokumen Word tidak dapat ditampilkan di browser. Gunakan tombol Download untuk membukanya.
                        </div>
                    @endif

                @else
                    <div style="padding:1rem; background:#f9fafb; border:1px dashed #d1d5db; border-radius:10px; color:#9ca3af; font-size:.875rem; text-align:center;">
                        Belum ada file yang diunggah.
                        <a href="{{ route('admin.letter-templates.edit', $letter_template) }}" style="color:#2563eb; margin-left:.25rem;">Upload sekarang</a>
                    </div>
                @endif
            </div>

            {{-- Meta --}}
            <div style="font-size:.78rem; color:#d1d5db;">
                Dibuat: {{ $letter_template->created_at?->format('d M Y, H:i') }}
                @if($letter_template->updated_at && $letter_template->updated_at != $letter_template->created_at)
                    · Diperbarui: {{ $letter_template->updated_at->format('d M Y, H:i') }}
                @endif
            </div>

        </div>
    </div>
</div>
@endsection