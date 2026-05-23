@extends('adminlte::page')
@section('title', 'Edit Sponsor')

@section('content_header')
<h1>Edit Sponsor</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('admin.settings._sidebar', ['group' => 'sponsor'])
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold">Form Edit Sponsor</h3>
            </div>
            <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Sponsor <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $sponsor->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Logo Sponsor</label>
                        <div class="col-sm-9">
                            <div class="mb-3">
                                @if($sponsor->logo)
                                    <div class="d-inline-block p-2 border rounded bg-light mb-2">
                                        <img src="{{ asset('storage/'.$sponsor->logo) }}" alt="Current Logo" style="height: 60px;">
                                    </div>
                                    <p class="small text-muted mb-2">Logo saat ini</p>
                                @endif
                            </div>

                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror" id="customFile" accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label" for="customFile">Pilih file logo baru...</label>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo. Format: JPG, PNG, WEBP, SVG. Maks: 2MB.</small>
                            @error('logo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            <div class="mt-3 d-none" id="preview-box">
                                <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded border p-2 bg-light" style="max-height: 100px;">
                                <p class="small text-muted mt-2">Preview Logo Baru</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Website URL</label>
                        <div class="col-sm-9">
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $sponsor->url) }}" placeholder="https://example.com">
                            @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Urutan</label>
                        <div class="col-sm-3">
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $sponsor->order) }}" min="0">
                            @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <div class="custom-control custom-switch mt-2">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActiveSwitch" value="1" {{ $sponsor->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="isActiveSwitch">Aktifkan sponsor ini</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top text-right">
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#preview-box').removeClass('d-none');
                $('.custom-file-label').text(input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop
