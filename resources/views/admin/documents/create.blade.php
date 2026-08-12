@extends('adminlte::page')

@section('title', 'Upload Dokumen')

@section('content_header')
    <h1><i class="fas fa-upload me-2"></i>Upload Dokumen Baru</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul / Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Pedoman Akademik 2026/2027">
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Kategori Dokumen <span class="text-danger">*</span></label>
                                <select name="document_category_id" class="form-control select2 @error('document_category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('document_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Status Visibilitas</label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_public" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_public">Bisa diakses Publik</label>
                                </div>
                                <small class="text-muted d-block mt-1">Jika dimatikan, hanya admin yang bisa melihat.</small>
                            </div>
                        </div>

                        <div class="form-group border-top pt-3 mt-2">
                            <label>Deskripsi Singkat Dokumen (Opsional)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group mt-3 p-4 bg-light rounded text-center" style="border: 2px dashed #cbd5e1;">
                            <label class="d-block mb-3"><i class="fas fa-file-upload fa-3x text-secondary"></i><br><br>Pilih File Dokumen <span class="text-danger">*</span></label>
                            <div class="custom-file mx-auto" style="max-width: 400px;">
                                <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="customFile" required>
                                <label class="custom-file-label text-left" for="customFile">Browse file...</label>
                            </div>
                            @error('file')<span class="text-danger d-block mt-2 font-weight-bold">{{ $message }}</span>@enderror
                            <div class="mt-3 text-muted text-sm">
                                <p class="mb-1"><strong>Format yang didukung:</strong> PDF, Word, Excel, PowerPoint, ZIP, Gambar.</p>
                                <p class="mb-0"><strong>Ukuran maksimal:</strong> 30 MB.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i> Mulai Upload</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title">Informasi</h3></div>
                <div class="card-body text-sm text-secondary">
                    <p>Dokumen yang diunggah akan disimpan di server lokal.</p>
                    <p>Format file yang diizinkan terbatas untuk keamanan (PDF, dokumen office, arsip zip/rar, dan gambar).</p>
                    <p>Nama asli file akan tetap dicatat dalam sistem saat dokumen diunduh.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@stop
