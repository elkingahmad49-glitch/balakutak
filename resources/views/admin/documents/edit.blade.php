@extends('adminlte::page')

@section('title', 'Edit Informasi Dokumen')

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>Edit Informasi Dokumen</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i> <strong>File Saat Ini:</strong> {{ $document->file_name }} ({{ number_format($document->file_size / 1024 / 1024, 2) }} MB) - Diunggah pada {{ $document->created_at->format('d M Y') }}
                        </div>

                        <div class="form-group mt-4">
                            <label>Judul / Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $document->title) }}" required placeholder="Contoh: Pedoman Akademik 2026/2027">
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Kategori Dokumen <span class="text-danger">*</span></label>
                                <select name="document_category_id" class="form-control select2 @error('document_category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('document_category_id', $document->document_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Status Visibilitas</label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_public" name="is_public" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_public">Bisa diakses Publik</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group border-top pt-3 mt-2">
                            <label>Deskripsi Singkat Dokumen (Opsional)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $document->description) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group mt-3 p-4 bg-light rounded text-center" style="border: 2px dashed #cbd5e1;">
                            <label class="d-block mb-3"><i class="fas fa-sync-alt fa-3x text-secondary"></i><br><br>Ganti File Dokumen (Opsional)</label>
                            <div class="custom-file mx-auto" style="max-width: 400px;">
                                <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="customFile">
                                <label class="custom-file-label text-left" for="customFile">Pilih file baru...</label>
                            </div>
                            @error('file')<span class="text-danger d-block mt-2 font-weight-bold">{{ $message }}</span>@enderror
                            <div class="mt-3 text-muted text-sm">
                                <p class="mb-1 text-info"><i class="fas fa-exclamation-triangle"></i> Biarkan kosong jika tidak ingin mengubah file saat ini.</p>
                                <p class="mb-0"><strong>Ukuran maksimal:</strong> 30 MB.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title">Aksi Dokumen</h3></div>
                <div class="card-body">
                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-block btn-outline-info mb-3">
                        <i class="fas fa-download me-1"></i> Download File Saat Ini
                    </a>
                    <div class="text-sm text-secondary">
                        <strong>Statistik Unduhan:</strong> {{ $document->download_count }} kali diunduh
                    </div>
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
