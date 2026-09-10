@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page_title', 'Edit Artikel')
@section('breadcrumb', 'Publikasi / Artikel / Edit')

@section('content')
<div style="max-width: 900px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Artikel</h2>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form id="articleForm" method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="title">Judul Artikel <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="category_id">Kategori <span style="color:#EF4444;">*</span></label>
                        <select id="category_id" name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">Status <span style="color:#EF4444;">*</span></label>
                        <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                            <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft (Simpan sementara)</option>
                            <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published (Terbitkan sekarang)</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="excerpt">Ringkasan (Excerpt)</label>
                    <textarea id="excerpt" name="excerpt" rows="2"
                        class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}"
                        placeholder="Teks singkat yang muncul di halaman daftar artikel">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Isi Artikel <span style="color:#EF4444;">*</span></label>
                    <textarea id="content" name="content" rows="15"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{{ old('content', $article->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- GALERI FOTO YANG SUDAH ADA -->
                <div class="form-group mt-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <label class="form-label text-lg font-bold text-gray-900 mb-2">Foto & Galeri Berita (Tersimpan)</label>
                    <p class="text-sm text-gray-500 mb-4">Pilih foto utama dari galeri atau hapus foto yang tidak diperlukan.</p>
                    
                    <div id="existing-gallery" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($article->images && $article->images->count() > 0)
                            @foreach($article->images as $img)
                                <div class="existing-img-card flex flex-col bg-white border p-2 rounded-lg shadow-sm transition-all {{ $img->is_cover ? 'border-blue-500 ring-1 ring-blue-500' : 'border-gray-200' }}" id="existing-img-{{ $img->id }}">
                                    <div class="relative w-full h-32 mb-2 bg-gray-100 rounded overflow-hidden">
                                        <img src="{{ asset('images/' . $img->image_path) }}" class="w-full h-full object-cover">
                                        @if($img->is_cover)
                                            <div class="absolute top-1 left-1 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow cover-badge">COVER</div>
                                        @endif
                                    </div>
                                    <input type="text" name="existing_captions[{{ $img->id }}]" value="{{ $img->caption }}" placeholder="Caption..." class="form-control form-control-sm mb-2 text-xs w-full">
                                    
                                    <div class="flex justify-between items-center text-xs mt-auto">
                                        <button type="button" class="btn-set-cover font-medium {{ $img->is_cover ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}" onclick="setExistingCover({{ $img->id }}, this)">
                                            {{ $img->is_cover ? '★ Utama' : 'Jadikan Utama' }}
                                        </button>
                                        <button type="button" class="text-red-500 hover:text-red-700 font-medium" onclick="removeExistingImage({{ $img->id }})">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-full text-center py-4 text-gray-400">
                                @if($article->thumbnail)
                                    <p>Artikel ini menggunakan gambar cover tunggal versi lama.</p>
                                    <img src="{{ asset('images/' . $article->thumbnail) }}" class="h-32 object-contain mx-auto mt-2">
                                @else
                                    <p>Belum ada foto galeri.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Hidden inputs for existing images state -->
                    <input type="hidden" name="cover_image_id" id="cover_image_id" value="">
                    <div id="deleted-images-container"></div>
                </div>

                <!-- TAMBAH FOTO BARU -->
                <div class="form-group mt-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <label class="form-label text-lg font-bold text-gray-900 mb-2">Tambah Foto Baru</label>
                    <p class="text-sm text-gray-500 mb-4">Tambahkan foto baru ke galeri.</p>
                    
                    <div class="mb-4">
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('gallery_images').click()">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Foto
                        </button>
                        <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none;" onchange="handleFiles(this.files)">
                        <input type="hidden" id="cover_image_index" name="cover_image_index" value="">
                    </div>
                    
                    <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Preview Images -->
                    </div>
                    @error('gallery_images.*')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Update Artikel</button>
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
    // --- EXISTING IMAGES LOGIC ---
    function setExistingCover(id, btnElement) {
        // Reset all existing cover UI
        document.querySelectorAll('.existing-img-card').forEach(card => {
            card.classList.remove('border-blue-500', 'ring-1', 'ring-blue-500');
            card.classList.add('border-gray-200');
            const badge = card.querySelector('.cover-badge');
            if (badge) badge.remove();
            
            const btn = card.querySelector('.btn-set-cover');
            if(btn) {
                btn.innerHTML = 'Jadikan Utama';
                btn.classList.remove('text-blue-600');
                btn.classList.add('text-gray-500', 'hover:text-blue-500');
            }
        });

        // Set new cover UI
        const card = document.getElementById('existing-img-' + id);
        card.classList.remove('border-gray-200');
        card.classList.add('border-blue-500', 'ring-1', 'ring-blue-500');
        
        const imgContainer = card.querySelector('.relative');
        imgContainer.insertAdjacentHTML('beforeend', '<div class="absolute top-1 left-1 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow cover-badge">COVER</div>');
        
        btnElement.innerHTML = '★ Utama';
        btnElement.classList.remove('text-gray-500', 'hover:text-blue-500');
        btnElement.classList.add('text-blue-600');

        // Set hidden input
        document.getElementById('cover_image_id').value = id;
        
        // Remove cover selection from new uploads
        document.getElementById('cover_image_index').value = '';
        renderPreviews();
    }

    function removeExistingImage(id) {
        if(confirm('Yakin ingin menghapus foto ini?')) {
            document.getElementById('existing-img-' + id).remove();
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = id;
            document.getElementById('deleted-images-container').appendChild(input);
        }
    }

    // --- NEW IMAGES LOGIC ---
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
        
        dt.items.clear();
        for (let i = 0; i < newDt.files.length; i++) {
            dt.items.add(newDt.files[i]);
        }
        document.getElementById('gallery_images').files = dt.files;
        
        let coverInput = document.getElementById('cover_image_index');
        if(coverInput.value !== '') {
            let currentCover = parseInt(coverInput.value);
            if (currentCover === index) coverInput.value = '';
            else if (currentCover > index) coverInput.value = currentCover - 1;
        }
        
        renderPreviews();
    }

    function setCover(index) {
        document.getElementById('cover_image_index').value = index;
        document.getElementById('cover_image_id').value = ''; // Unset existing cover
        
        // Reset UI for existing images
        document.querySelectorAll('.existing-img-card').forEach(card => {
            card.classList.remove('border-blue-500', 'ring-1', 'ring-blue-500');
            card.classList.add('border-gray-200');
            const badge = card.querySelector('.cover-badge');
            if (badge) badge.remove();
            
            const btn = card.querySelector('.btn-set-cover');
            if(btn) {
                btn.innerHTML = 'Jadikan Utama';
                btn.classList.remove('text-blue-600');
                btn.classList.add('text-gray-500', 'hover:text-blue-500');
            }
        });

        renderPreviews();
    }

    function renderPreviews() {
        const container = document.getElementById('gallery-preview');
        container.innerHTML = '';
        
        let coverIndex = document.getElementById('cover_image_index').value;
        if (coverIndex !== '') coverIndex = parseInt(coverIndex);

        if (dt.files.length > 0 && typeof coverIndex === 'number' && coverIndex >= dt.files.length) {
            coverIndex = 0;
            document.getElementById('cover_image_index').value = 0;
        }

        Array.from(dt.files).forEach((file, i) => {
            const isCover = i === coverIndex;
            const reader = new FileReader();
            
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

    document.getElementById('articleForm').addEventListener('submit', function() {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = 'Menyimpan...';
    });
</script>
@endpush
