@extends('adminlte::page')

@section('title', 'Tambah Slider')

@section('content_header')
    <h1><i class="fas fa-plus me-2"></i>Tambah Slider Beranda</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label>Gambar Slider / Banner <span class="text-danger">*</span></label>
                            
                            <div class="mb-3">
                                @include('admin.partials.media-input', [
                                    'name' => 'image', 
                                    'label' => false, 
                                    'value' => old('image')
                                ])
                            </div>

                            <div class="hr-text my-3 position-relative text-center">
                                <hr><span class="position-absolute bg-white px-2 small text-muted" style="top:50%;left:50%;transform:translate(-50%,-50%)">ATAU UPLOAD BARU</span>
                            </div>

                            <div class="custom-file mb-2">
                                <input type="file" name="image_file" class="custom-file-input @error('image_file') is-invalid @enderror" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile">Pilih gambar dari komputer...</label>
                            </div>
                            @error('image_file')<span class="text-danger d-block small">{{ $message }}</span>@enderror
                            <div class="alert alert-info py-2 m-0 mt-2 text-sm shadow-sm border-0 bg-light"><i class="fas fa-info-circle me-1 text-primary"></i> <span class="text-muted">Rekomendasi resolusi: 1920x800px (21:9). Maks: 4MB.</span></div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header border-0 pb-0">
                                <h6 class="font-weight-bold mb-0">Teks Utama Slider</h6>
                            </div>
                            <div class="card-body pt-3">
                                <div class="form-group">
                                    <label>Teks Judul Utama (Heading) <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Penerimaan Mahasiswa Baru">
                                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Teks Subjudul (Sub-heading) (Opsional)</label>
                                    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="Contoh: Tahun Ajaran 2026/2027">
                                    @error('subtitle')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 mt-4 mb-4 bg-light rounded">
                            <h6 class="font-weight-bold mb-3"><i class="fas fa-link me-1"></i>Tombol Tindakan (Call to Action)</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teks Tombol</label>
                                        <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="Contoh: Daftar Sekarang">
                                        @error('button_text')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>URL / Link Tujuan Tombol</label>
                                        <input type="text" name="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url') }}" placeholder="https://...">
                                        @error('button_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Biarkan kolom teks tombol kosong jika tidak ingin menampilkan tombol di slider.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Aktif (Tampilkan)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@stop
