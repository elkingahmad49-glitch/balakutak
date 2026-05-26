@extends('adminlte::page')

@section('title', 'Edit Agenda/Event')

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>Edit Agenda: {{ $event->title }}</h1>
@stop

@section('plugins.Summernote', true)

@section('content')
<div class="container-fluid">
    <div class="card">
        @if($errors->any())
            <div class="alert alert-danger m-3">
                <p><strong><i class="fas fa-exclamation-circle mr-1"></i> Terjadi kesalahan:</strong></p>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Agenda/Event <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $event->title) }}" required>
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Ringkasan Singkat <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Detail Konten / Informasi Lengkap</label>
                            <textarea name="content" class="form-control summernote @error('content') is-invalid @enderror">{{ old('content', $event->content) }}</textarea>
                            @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Waktu Selesai (Opsional)</label>
                                <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}">
                                @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location) }}" required>
                                @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Link Online (Zoom/Meet/dll)</label>
                                <input type="url" name="online_url" class="form-control @error('online_url') is-invalid @enderror" value="{{ old('online_url', $event->online_url) }}" placeholder="https://zoom.us/j/...">
                                @error('online_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="card card-outline card-secondary mt-3">
                            <div class="card-header"><h3 class="card-title">Pengaturan SEO</h3></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>SEO Title</label>
                                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $event->seo_meta['title'] ?? '') }}" placeholder="Maks 60 karakter">
                                </div>
                                <div class="form-group">
                                    <label>SEO Description</label>
                                    <textarea name="seo_description" class="form-control" rows="2" placeholder="Maks 160 karakter">{{ old('seo_description', $event->seo_meta['description'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card card-outline card-info shadow-sm">
                            <div class="card-header"><h3 class="card-title">Media & Penyelenggara</h3></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Gambar / Poster</label>
                                    @if($event->featured_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $event->featured_image) }}" alt="Poster" class="img-thumbnail" style="max-height: 150px">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="featured_image_file" class="custom-file-input @error('featured_image_file') is-invalid @enderror" id="customFile" accept="image/*">
                                        <label class="custom-file-label" for="customFile">Ganti gambar (opsional)</label>
                                    </div>
                                    @error('featured_image_file')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                    <small class="text-muted">Format: JPG, PNG. Maks: 4MB.</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Kategori Agenda</label>
                                    <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $event->category) }}" placeholder="Seminar, Workshop, dll">
                                </div>

                                <div class="form-group">
                                    <label>Penyelenggara</label>
                                    <input type="text" name="organizer" class="form-control @error('organizer') is-invalid @enderror" value="{{ old('organizer', $event->organizer) }}">
                                </div>

                                <div class="form-group">
                                    <label>Kontak Person</label>
                                    <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $event->contact_person) }}" placeholder="Nama/No HP">
                                </div>

                                <hr>
                                <h5>Pendaftaran</h5>
                                
                                <div class="form-group">
                                    <label>Link Pendaftaran External</label>
                                    <input type="url" name="registration_url" class="form-control @error('registration_url') is-invalid @enderror" value="{{ old('registration_url', $event->registration_url) }}" placeholder="https://bit.ly/reg-acara">
                                </div>

                                <div class="form-group">
                                    <label>Batas Waktu Pendaftaran</label>
                                    <input type="datetime-local" name="registration_deadline" class="form-control @error('registration_deadline') is-invalid @enderror" value="{{ old('registration_deadline', $event->registration_deadline?->format('Y-m-d\TH:i')) }}">
                                </div>
                                
                                <div class="form-group">
                                    <label>Maksimal Peserta</label>
                                    <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror" value="{{ old('max_participants', $event->max_participants) }}" min="1">
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_free" name="is_free" value="1" {{ old('is_free', $event->is_free) ? 'checked' : '' }} onchange="document.getElementById('price_container').style.display = this.checked ? 'none' : 'block'">
                                        <label class="custom-control-label" for="is_free">Acara Gratis</label>
                                    </div>
                                </div>
                                
                                <div class="form-group" id="price_container" style="display: {{ old('is_free', $event->is_free) ? 'none' : 'block' }}">
                                    <label>Harga Tiket (Rp)</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $event->price) }}" min="0">
                                </div>

                                <hr>
                                
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_published">Status Publikasi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        if (typeof bsCustomFileInput !== 'undefined') {
            bsCustomFileInput.init();
        }
        
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@stop
