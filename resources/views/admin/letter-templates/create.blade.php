@extends('layouts.admin')

@section('title', 'Tambah Template Surat')
@section('page_title', 'Tambah Template Surat')

@section('content')
<div class="card" style="max-width:720px;">
    <div class="card-header">
        <h2 class="card-title">Tambah Template Surat</h2>
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

        <form action="{{ route('admin.letter-templates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Template --}}
            <div class="form-group">
                <label for="name" style="font-weight:600;">Nama Template Surat <span style="color:#dc2626;">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Contoh: Surat Undangan" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="description" style="font-weight:600;">Deskripsi</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="3" placeholder="Deskripsi singkat template ini">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- File Upload --}}
            <div class="form-group">
                <label for="template_file" style="font-weight:600;">File Template <span style="color:#dc2626;">*</span></label>
                <div style="margin-top:.5rem;">
                    <input type="file" id="template_file" name="template_file"
                           accept=".pdf,.doc,.docx"
                           class="form-control @error('template_file') is-invalid @enderror"
                           onchange="showFileName(this, 'file-name-display')">
                    @error('template_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div id="file-name-display" style="margin-top:.5rem; font-size:.82rem; color:#6b7280; word-break:break-all; display:none;"></div>
                <div style="margin-top:.4rem; font-size:.78rem; color:#9ca3af;">
                    Format yang diperbolehkan: Word (.doc, .docx) atau PDF (.pdf). Maks. 10 MB.
                </div>
            </div>

            <div style="margin-top:1.5rem; display:flex; gap:.75rem; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">Simpan Template</button>
                <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-secondary">Batal</a>
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