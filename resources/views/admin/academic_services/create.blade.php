@extends('adminlte::page')

@section('title', 'Tambah Layanan Akademik')

@section('content_header')
    <h1><i class="fas fa-plus mr-2"></i>Tambah Layanan Akademik</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-primary card-outline shadow-sm">
                <form action="{{ route('admin.academic-services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: SIAKAD Mahasiswa">
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Icon (FontAwesome)</label>
                                <div class="input-group">
                                    <input type="text" id="iconInput" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', 'fas fa-link') }}" placeholder="fas fa-link">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    </div>
                                </div>
                                <small class="text-muted">Contoh: <code>fas fa-graduation-cap</code></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Atau Upload Icon (Gambar)</label>
                                <div class="custom-file mb-1">
                                    <input type="file" name="icon_image" class="custom-file-input @error('icon_image') is-invalid @enderror" id="iconImage" accept="image/*" onchange="previewIcon(this)">
                                    <label class="custom-file-label" for="iconImage">Pilih file...</label>
                                </div>
                                <small class="text-muted">PNG, JPG, SVG, WebP. Maks 1MB.</small>
                                
                                <div id="iconPreview" class="mt-2 d-none">
                                    <label class="small fw-bold">Preview Icon:</label>
                                    <div>
                                        <img src="" id="previewIconImg" class="img-thumbnail" style="max-height: 45px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>URL / Tautan Link <span class="text-danger">*</span></label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" required placeholder="https://siakad.kampus.ac.id">
                            @error('url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_external" name="is_external" value="1" {{ old('is_external', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_external">Tautan Eksternal</label>
                                </div>
                                <small class="text-muted">Aktifkan jika link menuju ke luar website ini.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Aktifkan Layanan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.academic-services.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });

    function previewIcon(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewIconImg').src = e.target.result;
                document.getElementById('iconPreview').classList.remove('d-none');
                document.getElementById('iconInput').value = ''; // Clear FA class when uploading custom icon
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop
