@extends('adminlte::page')

@section('title', __('admin.edit_page'))

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>{{ __('admin.edit_page') }}: {{ $page->title }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>{{ __('admin.page_title') }} <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">{{ __('admin.page_content') }} <span class="text-danger">*</span></label>
                                
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
                                <textarea name="content" id="contentEditor" class="form-control content-editor @error('content') is-invalid @enderror">{{ old('content', $page->content) }}</textarea>
                                <textarea id="codeEditor" class="form-control" rows="25" style="display: none; height: 600px !important; min-height: 600px !important; font-family: 'Courier New', Courier, monospace !important; font-size: 14px !important; background-color: #1e293b !important; color: #f8fafc !important; caret-color: #ffffff !important; border: 1px solid #475569 !important; border-radius: 8px !important; padding: 1rem !important; line-height: 1.5 !important; resize: vertical !important; direction: ltr !important; text-align: left !important;" placeholder="Tulis kode HTML di sini..."></textarea>
                            </div>
                            @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label>{{ __('admin.post_excerpt') }}</label>
                            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $page->excerpt) }}</textarea>
                            @error('excerpt')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-outline card-info shadow-sm">
                            <div class="card-header"><h3 class="card-title">{{ __('admin.post_settings') }}</h3></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('admin.post_image') }}</label>
                                    
                                    <div class="mb-2">
                                        @include('admin.partials.media-input', [
                                            'name' => 'featured_image', 
                                            'label' => false, 
                                            'value' => old('featured_image', $page->featured_image)
                                        ])
                                    </div>

                                    <div class="hr-text my-2 position-relative text-center">
                                        <hr><span class="position-absolute bg-white px-2 small text-muted" style="top:50%;left:50%;transform:translate(-50%,-50%)">OR UPLOAD NEW</span>
                                    </div>

                                    <div class="custom-file">
                                        <input type="file" name="featured_image_file" class="custom-file-input @error('featured_image_file') is-invalid @enderror" id="customFile" accept="image/*">
                                        <label class="custom-file-label" for="customFile">{{ __('admin.image') }}</label>
                                    </div>
                                    @error('featured_image_file')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_builder" name="is_builder" value="1" {{ old('is_builder', $page->is_builder) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_builder">{{ __('admin.use_page_builder') }}</label>
                                    </div>
                                    <small class="text-muted">{{ __('admin.page_builder_hint') }}</small>
                                </div>
                                <hr>
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_published">{{ __('admin.post_status') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ $page->is_builder ? route('admin.pages.builder-index') : route('admin.pages.index') }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('admin.save_page') }}</button>
            </div>
        </form>
    </div>
</div>
@include('admin.partials.media-modal')
@stop

@section('js')
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@stop
