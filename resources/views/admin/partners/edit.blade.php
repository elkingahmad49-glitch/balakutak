@extends('adminlte::page')
@section('title', 'Edit Mitra Kerjasama')

@section('content_header')
    <h1><i class="fas fa-handshake mr-2"></i>Edit Mitra Kerjasama</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline shadow-sm border-0" style="border-radius: 12px;">
            <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nama Mitra <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $partner->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Logo</label>
                        <div class="col-sm-9">
                            @if($partner->logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" id="current_logo" style="max-height:80px; border-radius:8px; background:#f8f9fa; padding:6px; border:1px solid #e2e8f0;">
                                    <small class="d-block text-muted mt-1">Logo saat ini. Upload baru untuk mengganti.</small>
                                </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*" onchange="previewLogo(this)">
                                <label class="custom-file-label" for="logo">Pilih file logo baru (opsional)...</label>
                            </div>
                            <small class="text-muted">Format: JPG, PNG, SVG, WebP. Maks 2MB.</small>
                            @error('logo')<span class="text-danger small">{{ $message }}</span>@enderror
                            <div id="logo_preview" class="mt-3 d-none">
                                <img id="preview_img" src="" alt="Preview" style="max-height:80px; border-radius:8px; background:#f8f9fa; padding:6px; border:1px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Website URL</label>
                        <div class="col-sm-9">
                            <input type="url" name="website_url" class="form-control @error('website_url') is-invalid @enderror" value="{{ old('website_url', $partner->website_url) }}" placeholder="https://example.com">
                            @error('website_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Deskripsi</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $partner->description) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Urutan</label>
                        <div class="col-sm-3">
                            <input type="number" name="order" class="form-control" value="{{ old('order', $partner->order) }}" min="0">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-9 offset-sm-3">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="is_active">Tampilkan di Landing Page</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top p-4 d-flex justify-content-between">
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview_img').src = e.target.result;
            document.getElementById('logo_preview').classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
        document.querySelector('.custom-file-label').textContent = input.files[0].name;
    }
}
</script>
@endpush
@stop
