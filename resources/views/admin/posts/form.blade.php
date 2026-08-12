@extends('adminlte::page')

@section('title', (isset($post) ? 'Edit' : 'Tambah') . ' Artikel')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-edit me-2"></i>{{ isset($post) ? 'Edit' : 'Tambah' }} Artikel</h1>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
@stop

@section('content')
<form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div class="row">

        {{-- Main Column --}}
        <div class="col-lg-8">

            {{-- Title --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="titleInput" class="form-control form-control-lg @error('title') is-invalid @enderror"
                               placeholder="Masukkan judul artikel..."
                               value="{{ old('title', $post->title ?? '') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="fw-semibold">Slug URL</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted" style="font-size:.8rem">{{ url('/berita') }}/</span>
                            <input type="text" name="slug" id="slugInput" class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug', $post->slug ?? '') }}" placeholder="auto-generate dari judul">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Ringkasan</label>
                        <textarea name="excerpt" rows="2" class="form-control" placeholder="Ringkasan singkat artikel...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="fw-semibold mb-0">Isi Artikel <span class="text-danger">*</span></label>
                            
                            <div class="btn-group btn-group-sm" role="group" aria-label="Editor Mode">
                                <button type="button" class="btn btn-primary active" id="btn-mode-visual">
                                    <i class="fas fa-eye mr-1"></i> Visual
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="btn-mode-code">
                                    <i class="fas fa-code mr-1"></i> Code (HTML)
                                </button>
                            </div>
                        </div>
                        
                        <div id="editor-wrapper">
                            <textarea name="content" id="contentEditor" class="form-control @error('content') is-invalid @enderror content-editor" rows="15">{{ old('content', $post->content ?? '') }}</textarea>
                            <textarea id="codeEditor" class="form-control" rows="25" style="display: none; height: 600px !important; min-height: 600px !important; font-family: 'Courier New', Courier, monospace !important; font-size: 14px !important; background-color: #1e293b !important; color: #f8fafc !important; caret-color: #ffffff !important; border: 1px solid #475569 !important; border-radius: 8px !important; padding: 1rem !important; line-height: 1.5 !important; resize: vertical !important; direction: ltr !important; text-align: left !important;" placeholder="Tulis kode HTML di sini..."></textarea>
                        </div>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search me-2"></i>SEO</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label>Meta Title</label>
                        <input type="text" name="seo_title" class="form-control" placeholder="Judul untuk mesin pencari (60 karakter)"
                               value="{{ old('seo_title', $post->seo_meta['title'] ?? '') }}" maxlength="60">
                    </div>
                    <div class="form-group mb-3">
                        <label>Meta Description</label>
                        <textarea name="seo_description" class="form-control" rows="2" placeholder="Deskripsi untuk mesin pencari (160 karakter)" maxlength="160">{{ old('seo_description', $post->seo_meta['description'] ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <input type="text" name="seo_keywords" class="form-control" placeholder="kata kunci, dipisah koma"
                               value="{{ old('seo_keywords', $post->seo_meta['keywords'] ?? '') }}">
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Publish Box --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white"><h3 class="card-title">Publikasi</h3></div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>🔵 Draft</option>
                            @can('publish posts')
                            <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>🟢 Published</option>
                            @endcan
                            <option value="archived" {{ old('status', $post->status ?? '') === 'archived' ? 'selected' : '' }}>🔴 Archived</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Tanggal Publikasi</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_featured" id="isFeatured" class="form-check-input" value="1"
                               {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isFeatured">⭐ Artikel Unggulan (Featured)</label>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="allow_comments" id="allowComments" class="form-check-input" value="1"
                               {{ old('allow_comments', $post->allow_comments ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allowComments">💬 Izinkan Komentar</label>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-save me-1"></i> {{ isset($post) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                    @if(isset($post))
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Category & Type --}}
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Kategorisasi</h3></div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Tipe</label>
                        <select name="type" class="form-control select2">
                            <option value="post" {{ old('type', $post->type ?? 'post') === 'post' ? 'selected' : '' }}>Artikel</option>
                            <option value="news" {{ old('type', $post->type ?? '') === 'news' ? 'selected' : '' }}>Berita</option>
                            <option value="research" {{ old('type', $post->type ?? '') === 'research' ? 'selected' : '' }}>Penelitian</option>
                            <option value="community" {{ old('type', $post->type ?? '') === 'community' ? 'selected' : '' }}>Pengabdian</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 d-none">
                        <label class="fw-semibold">Bahasa <span class="text-danger">*</span></label>
                        <select name="language" class="form-control">
                            <option value="id" selected>Indonesia</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kategori</label>
                        <select name="category_id" class="form-control select2">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Tag</label>
                        <select name="tags[]" id="tagsSelect" class="form-control select2" multiple>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="fw-semibold">Keterkaitan SDGs</label>
                        @php
                            $sdgList = [
                                    1 => 'No Poverty',
                                    2 => 'Zero Hunger',
                                    3 => 'Good Health and Well-being',
                                    4 => 'Quality Education',
                                    5 => 'Gender Equality',
                                    6 => 'Clean Water and Sanitation',
                                    7 => 'Affordable and Clean Energy',
                                    8 => 'Decent Work and Economic Growth',
                                    9 => 'Industry, Innovation and Infrastructure',
                                    10 => 'Reduced Inequality',
                                    11 => 'Sustainable Cities and Communities',
                                    12 => 'Responsible Consumption and Production',
                                    13 => 'Climate Action',
                                    14 => 'Life Below Water',
                                    15 => 'Life on Land',
                                    16 => 'Peace and Justice Strong Institutions',
                                    17 => 'Partnerships to achieve the Goal',
                            ];
                            $savedSdgs = old('sdgs', isset($post) ? (is_array($post->sdgs) ? $post->sdgs : json_decode($post->sdgs, true) ?? []) : []);
                        @endphp
                        <select name="sdgs[]" class="form-control select2" multiple data-placeholder="Pilih SDGs yang relevan">
                            @foreach($sdgList as $num => $desc)
                            @php $sdgLabel = "SDGs $num - $desc"; @endphp
                            <option value="{{ $sdgLabel }}" {{ in_array($sdgLabel, $savedSdgs) || in_array("SDGs $num", $savedSdgs) ? 'selected' : '' }}>
                                {{ $sdgLabel }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">Pilih satu atau lebih SDGs yang relevan dengan artikel.</small>
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white"><h3 class="card-title">Gambar Utama</h3></div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="small text-muted mb-2 d-block">Pilih gambar utama untuk artikel ini. Bisa upload baru atau ambil dari galeri yang sudah ada.</label>
                        
                        <div class="mb-3">
                            @include('admin.partials.media-input', [
                                'name' => 'featured_image', 
                                'label' => 'Pilih dari PDF/Galeri', 
                                'value' => old('featured_image', $post->featured_image ?? '')
                            ])
                        </div>

                        <div class="hr-text my-3 text-center position-relative">
                            <hr><span class="position-absolute px-2 bg-white text-muted small" style="top:50%;left:50%;transform:translate(-50%,-50%)">ATAU UPLOAD BARU</span>
                        </div>

                        <div class="custom-file">
                            <input type="file" name="featured_image_file" class="custom-file-input" id="featuredImageFile" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="featuredImageFile">Upload dari komputer...</label>
                        </div>
                    </div>
                    
                    <div id="imagePreview" class="mb-2 {{ isset($post) && $post->featured_image ? '' : 'd-none' }}">
                        <label class="small fw-bold">Preview terpilih:</label>
                        <img src="{{ isset($post) && $post->featured_image ? $post->featured_image_url : '' }}" id="previewImg" class="img-fluid rounded border shadow-sm w-100" style="max-height:200px; object-fit: cover;">
                    </div>

                    @if(isset($post) && $post->featured_image)
                    <div class="form-check mt-2">
                        <input type="checkbox" name="remove_image" id="removeImage" class="form-check-input" value="1">
                        <label class="form-check-label text-danger small" for="removeImage">Hapus gambar utama</label>
                    </div>
                    @endif
                    <small class="text-muted d-block mt-2 font-italic">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                </div>
            </div>

        </div>
    </div>
</form>
@include('admin.partials.media-modal')
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css">
<style>
/* Make the content editor taller */
#contentEditor { min-height: 400px; }
</style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
        // TinyMCE Editor - Premium Modern Config
        tinymce.init({
            selector: '.content-editor',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image media table | charmap emoticons | code fullscreen preview',
            toolbar_sticky: true,
            toolbar_mode: 'sliding',
            autosave_ask_before_unload: true,
            height: 600,
            image_title: true,
            automatic_uploads: true,
            promotion: false,
            branding: false,
            images_upload_url: '{{ route("admin.media.upload") }}',
            relative_urls: false,
            remove_script_host: false,
            verify_html: false,
            extended_valid_elements: 'style[*],script[*],iframe[*],div[*],span[*],p[*],a[*],section[*],article[*],footer[*],header[*],nav[*]',
            valid_children: '+body[style|script],+div[style|script],+span[style|script],+p[style|script],+section[style|script],+article[style|script],+header[style|script],+footer[style|script],+aside[style|script],+nav[style|script]',
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                if (meta.filetype === 'image') {
                    currentInput = null;
                    currentPreview = null;
                    $('#mediaPickerModal').modal('show');
                    if (typeof window.loadMedia === 'function') window.loadMedia();
                    window.tinyMceCallback = function(item) {
                        cb(item.url, { title: item.filename, alt: item.filename });
                    };
                }
            },
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("admin.media.upload") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.upload.onprogress = (e) => { progress(e.loaded / e.total * 100); };
                xhr.onload = () => {
                    if (xhr.status === 403) { reject({ message: 'HTTP Error: ' + xhr.status, remove: true }); return; }
                    if (xhr.status < 200 || xhr.status >= 300) { reject('HTTP Error: ' + xhr.status); return; }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || (typeof json.location != 'string' && (!json.data || !json.data[0]))) {
                        reject('Invalid JSON: ' + xhr.responseText); return;
                    }
                    resolve(json.location || json.data[0]);
                };
                xhr.onerror = () => { reject('Image upload failed. Code: ' + xhr.status); };
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),
            content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:14px; line-height: 1.6; color: #333; }',
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            contextmenu: 'link image table',
        });

        // CSS to hide the "Upgrade" button and clean up UI
        const style = document.createElement('style');
        style.innerHTML = `
            .tox-promotion, .tox-statusbar__branding { display: none !important; }
            .tox-tinymce { border-radius: 8px !important; border: 1px solid #e2e8f0 !important; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important; }
            .tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary { background-color: #f8fafc !important; }
        `;
        document.head.appendChild(style);

// Slug generation
document.getElementById('titleInput')?.addEventListener('input', function() {
    generateSlug();
});

function generateSlug() {
    const title = document.getElementById('titleInput').value;
    const slug = title.toLowerCase()
        .replace(/[àáâãäå]/g, 'a').replace(/[èéêë]/g, 'e')
        .replace(/[ìíîï]/g, 'i').replace(/[òóôõö]/g, 'o')
        .replace(/[ùúûü]/g, 'u')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim().replace(/\s+/g, '-').replace(/-+/g, '-');
    document.getElementById('slugInput').value = slug;
}

// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Select2
$(document).ready(function() {
    $('.select2').not('#tagsSelect').select2({ theme: 'default', width: '100%' });
    $('#tagsSelect').select2({ theme: 'default', width: '100%', tags: true, tokenSeparators: [','] });
    
    if(typeof bsCustomFileInput !== 'undefined') bsCustomFileInput.init();

    // Tab Visual / Code toggles
    const btnVisual = document.getElementById('btn-mode-visual');
    const btnCode = document.getElementById('btn-mode-code');
    const codeEditor = document.getElementById('codeEditor');
    const contentEditor = document.getElementById('contentEditor');
    let currentMode = 'visual';

    if (btnVisual && btnCode && codeEditor) {
        btnVisual.addEventListener('click', function () {
            if (currentMode === 'visual') return;
            
            const codeVal = codeEditor.value;
            const editor = tinymce.get('contentEditor');
            if (editor) {
                editor.setContent(codeVal);
            } else {
                contentEditor.value = codeVal;
            }
            
            codeEditor.style.display = 'none';
            const tinymceContainer = document.querySelector('.tox-tinymce');
            if (tinymceContainer) {
                tinymceContainer.style.display = 'flex';
            }
            
            btnVisual.classList.add('btn-primary', 'active');
            btnVisual.classList.remove('btn-outline-primary');
            btnCode.classList.remove('btn-primary', 'active');
            btnCode.classList.add('btn-outline-primary');
            
            currentMode = 'visual';
        });

        btnCode.addEventListener('click', function () {
            if (currentMode === 'code') return;
            
            let htmlVal = '';
            const editor = tinymce.get('contentEditor');
            if (editor) {
                htmlVal = editor.getContent();
            } else {
                htmlVal = contentEditor.value;
            }
            
            codeEditor.value = htmlVal;
            
            const tinymceContainer = document.querySelector('.tox-tinymce');
            if (tinymceContainer) {
                tinymceContainer.style.display = 'none';
            }
            codeEditor.style.display = 'block';
            
            btnCode.classList.add('btn-primary', 'active');
            btnCode.classList.remove('btn-outline-primary');
            btnVisual.classList.remove('btn-primary', 'active');
            btnVisual.classList.add('btn-outline-primary');
            
            currentMode = 'code';
        });

        const form = btnVisual.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                if (currentMode === 'code') {
                    const codeVal = codeEditor.value;
                    const editor = tinymce.get('contentEditor');
                    if (editor) {
                        editor.setContent(codeVal);
                        editor.save();
                    } else {
                        contentEditor.value = codeVal;
                    }
                }
            });
        }
    }
});
</script>
@stop
