@extends('adminlte::page')

@section('title', 'Edit Menu')

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>Edit Menu: {{ $menu->name }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $menu->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Lokasi (Identifier / Slug) <span class="text-danger">*</span></label>
                            <select name="location" class="form-control @error('location') is-invalid @enderror" required>
                                <option value="">-- Pilih Lokasi Menu --</option>
                                <option value="top-menu" {{ old('location', $menu->location) == 'top-menu' ? 'selected' : '' }}>Top Menu (Diatas Header)</option>
                                <option value="main-menu" {{ old('location', $menu->location) == 'main-menu' ? 'selected' : '' }}>Main Menu (Header)</option>
                                <option value="secondary-menu" {{ old('location', $menu->location) == 'secondary-menu' ? 'selected' : '' }}>Secondary Menu (Bawah Main Menu)</option>
                                <option value="footer-menu" {{ old('location', $menu->location) == 'footer-menu' ? 'selected' : '' }}>Footer Menu (Footer)</option>
                            </select>
                            <small class="text-muted">Pilih lokasi di mana menu ini akan ditampilkan.</small>
                            @error('location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktifkan Menu</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-default">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
