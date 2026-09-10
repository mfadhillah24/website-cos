@extends('layouts.admin')

@section('title', 'Edit Template Surat')
@section('page_title', 'Edit Template Surat')

@section('content')
<div class="card" style="max-width:720px;">
    <div class="card-header">
        <h2 class="card-title">Edit Template Surat</h2>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:1.25rem;">
                <ul style="margin:0; padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.letter-templates.update', $letter_template) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama Template --}}
            <div class="form-group">
                <label for="name" style="font-weight:600;">Nama Template Surat <span style="color:#dc2626;">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $letter_template->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="description" style="font-weight:600;">Deskripsi</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="3">{{ old('description', $letter_template->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- File Upload --}}
            <div class="form-group">
                <label for="template_file" style="font-weight:600;">File Template Baru</label>

                {{-- Current file info --}}
                @if($letter_template->file_path)
                    @php
                        $ext = strtolower($letter_template->file_extension ?? '');
                        $isPdf = $ext === 'pdf';
                        $badgeColor = $isPdf ? '#cf1322' : '#1d4ed8';
                        $badgeBg    = $isPdf ? '#fff1f0' : '#eff6ff';
                        $fileSize   = $letter_template->file_size ? round($letter_template->file_size / 1024, 1) . ' KB' : '';
                    @endphp
                    <div style="margin-top:.5rem; margin-bottom:.75rem; padding:.75rem 1rem; background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;">
                        <span style="padding:.15rem .55rem; border-radius:6px; font-size:.72rem; font-weight:700; background:{{ $badgeBg }}; color:{{ $badgeColor }};">
                            {{ strtoupper($ext) }}
                        </span>
                        <span style="font-size:.85rem; color:#374151; word-break:break-all; flex:1; min-width:0;">
                            {{ $letter_template->file_name ?? basename($letter_template->file_path) }}
                        </span>
                        @if($fileSize)
                            <span style="font-size:.78rem; color:#9ca3af; flex-shrink:0;">{{ $fileSize }}</span>
                        @endif
                        <a href="{{ route('admin.letter-templates.download', $letter_template) }}"
                           style="font-size:.78rem; color:#2563eb; flex-shrink:0;">Download</a>
                    </div>
                    <div style="font-size:.8rem; color:#6b7280; margin-bottom:.5rem;">
                        Biarkan kosong untuk mempertahankan file saat ini.
                    </div>
                @else
                    <div style="font-size:.8rem; color:#9ca3af; margin-top:.25rem; margin-bottom:.5rem;">
                        Belum ada file yang diunggah.
                    </div>
                @endif

                <input type="file" id="template_file" name="template_file"
                       accept=".pdf,.doc,.docx"
                       class="form-control @error('template_file') is-invalid @enderror"
                       onchange="showFileName(this, 'file-name-display')">
                @error('template_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div id="file-name-display" style="margin-top:.5rem; font-size:.82rem; color:#6b7280; word-break:break-all; display:none;"></div>
                <div style="margin-top:.4rem; font-size:.78rem; color:#9ca3af;">
                    Format yang diperbolehkan: Word (.doc, .docx) atau PDF (.pdf). Maks. 10 MB.
                </div>
            </div>

            <div style="margin-top:1.5rem; display:flex; gap:.75rem; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.letter-templates.show', $letter_template) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function showFileName(input, targetId) {
    var display = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        display.textContent = '📄 ' + input.files[0].name;
        display.style.display = 'block';
    } else {
        display.style.display = 'none';
    }
}
</script>
@endsection