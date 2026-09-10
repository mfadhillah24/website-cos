@extends('layouts.admin')

@section('title', 'Tulis Artikel')
@section('page_title', 'Tulis Artikel Baru')
@section('breadcrumb', 'Publikasi / Artikel / Tulis')

@section('content')
<div style="max-width: 900px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Artikel Baru</h2>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form id="articleForm" method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Judul Artikel <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="category_id">Kategori <span style="color:#EF4444;">*</span></label>
                        <select id="category_id" name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">Status <span style="color:#EF4444;">*</span></label>
                        <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Simpan sementara)</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Terbitkan sekarang)</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="excerpt">Ringkasan (Excerpt)</label>
                    <textarea id="excerpt" name="excerpt" rows="2"
                        class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}"
                        placeholder="Teks singkat yang muncul di halaman daftar artikel">{{ old('excerpt') }}</textarea>
                    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Isi Artikel <span style="color:#EF4444;">*</span></label>
                    <textarea id="content" name="content" rows="15"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mt-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <label class="form-label text-lg font-bold text-gray-900 mb-2">Foto & Galeri Berita</label>
                    <p class="text-sm text-gray-500 mb-4">Tambahkan banyak foto sekaligus. Anda bisa memilih satu foto untuk dijadikan Cover (Foto Utama).</p>
                    
                    <div class="mb-4">
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('gallery_images').click()">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Foto
                        </button>
                        <!-- multiple file input dihidden -->
                        <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none;" onchange="handleFiles(this.files)">
                        <input type="hidden" id="cover_image_index" name="cover_image_index" value="0">
                    </div>
                    
                    <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Preview Images -->
                    </div>
                    @error('gallery_images.*')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan Artikel</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        language: 'id',
        height: 600,
        image_title: true,
        automatic_uploads: true,
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('admin.articles.upload-image') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            
            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }
                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }
                const json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        })
    });
</script>

<script>
    const dt = new DataTransfer();

    function handleFiles(files) {
        for (let i = 0; i < files.length; i++) {
            dt.items.add(files[i]);
        }
        document.getElementById('gallery_images').files = dt.files;
        renderPreviews();
    }

    function removeFile(index) {
        const newDt = new DataTransfer();
        for (let i = 0; i < dt.files.length; i++) {
            if (i !== index) newDt.items.add(dt.files[i]);
        }
        
        // update dt object
        dt.items.clear();
        for (let i = 0; i < newDt.files.length; i++) {
            dt.items.add(newDt.files[i]);
        }
        document.getElementById('gallery_images').files = dt.files;
        
        // adjust cover index
        let coverInput = document.getElementById('cover_image_index');
        let currentCover = parseInt(coverInput.value);
        if (currentCover === index) coverInput.value = 0;
        else if (currentCover > index) coverInput.value = currentCover - 1;
        
        renderPreviews();
    }

    function setCover(index) {
        document.getElementById('cover_image_index').value = index;
        renderPreviews();
    }

    function renderPreviews() {
        const container = document.getElementById('gallery-preview');
        container.innerHTML = '';
        
        let coverIndex = parseInt(document.getElementById('cover_image_index').value);
        if (dt.files.length > 0 && coverIndex >= dt.files.length) {
            coverIndex = 0;
            document.getElementById('cover_image_index').value = 0;
        }

        Array.from(dt.files).forEach((file, i) => {
            const isCover = i === coverIndex;
            const reader = new FileReader();
            
            // Create a wrapper div
            const div = document.createElement('div');
            div.className = "flex flex-col bg-white border p-2 rounded-lg shadow-sm transition-all " + (isCover ? "border-blue-500 ring-1 ring-blue-500" : "border-gray-200");
            
            reader.onload = function(e) {
                div.innerHTML = `
                    <div class="relative w-full h-32 mb-2 bg-gray-100 rounded overflow-hidden">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        ${isCover ? '<div class="absolute top-1 left-1 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">COVER</div>' : ''}
                    </div>
                    <input type="text" name="gallery_captions[]" placeholder="Caption..." class="form-control form-control-sm mb-2 text-xs w-full">
                    <div class="flex justify-between items-center text-xs mt-auto">
                        <button type="button" class="font-medium ${isCover ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500'}" onclick="setCover(${i})">
                            ${isCover ? '★ Utama' : 'Jadikan Utama'}
                        </button>
                        <button type="button" class="text-red-500 hover:text-red-700 font-medium" onclick="removeFile(${i})">Hapus</button>
                    </div>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }

    // Optional: Prevent duplicate submit
    document.getElementById('articleForm').addEventListener('submit', function() {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = 'Menyimpan...';
    });
</script>
@endpush
