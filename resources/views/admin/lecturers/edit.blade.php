@extends('adminlte::page')

@section('title', 'Edit Dosen/Staff')

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>Edit Data Dosen/Staff</h1>
@stop

@section('plugins.Summernote', true)

@section('content')
<div class="container-fluid">
    <div class="card">
        <form action="{{ route('admin.lecturers.update', $lecturer) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 border-right pr-4">
                        <h5 class="mb-3 text-info border-bottom pb-2">Identitas Utama</h5>
                        
                        <div class="form-group text-center">
                            <label>Foto Profil</label>
                            <div class="mb-3">
                                <img id="preview" src="{{ $lecturer->photo_url }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="customFile" accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label" for="customFile">Pilih foto baru</label>
                            </div>
                            @error('photo')<span class="text-danger d-block text-left text-sm mt-1">{{ $message }}</span>@enderror
                            <small class="text-muted text-left d-block mt-1">Biarkan kosong jika tidak mengubah foto. Maks 2MB.</small>
                        </div>
                        
                        <div class="form-group mt-4">
                            <label>Tipe Profile <span class="text-danger">*</span></label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="dosen" {{ old('type', $lecturer->type) == 'dosen' ? 'selected' : '' }}>Dosen Pengajar</option>
                                <option value="tendik" {{ old('type', $lecturer->type) == 'tendik' ? 'selected' : '' }}>Tenaga Kependidikan (Staff)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Urutan Tampil (Order)</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $lecturer->order) }}" min="0">
                            <small class="text-muted">Urutan angka kecil tampil lebih awal</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Status Aktif</label>
                            <div class="custom-control custom-switch mt-1">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', $lecturer->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktif di Website</label>
                            </div>
                            @error('is_active')<span class="text-danger text-sm mt-1 d-block">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="col-md-9 pl-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3 text-info border-bottom pb-2">Data Personal</h5>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Nama Lengkap (Serta Gelar) <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $lecturer->name) }}" required placeholder="Contoh: Dr. Budi Santoso, M.Kom">
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $lecturer->nip) }}">
                                @error('nip')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label>NIDN</label>
                                <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn', $lecturer->nidn) }}">
                                @error('nidn')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Jabatan Akademik</label>
                                <input type="text" name="academic_title" class="form-control @error('academic_title') is-invalid @enderror" value="{{ old('academic_title', $lecturer->academic_title) }}" placeholder="Lektor Kepala, Guru Besar...">
                                @error('academic_title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Jabatan Fungsional/Struktural</label>
                                <input type="text" name="functional_position" class="form-control @error('functional_position') is-invalid @enderror" value="{{ old('functional_position', $lecturer->functional_position) }}" placeholder="Ketua Program Studi...">
                                @error('functional_position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Jabatan Umum (Ditampilkan utama)</label>
                                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $lecturer->position) }}" placeholder="Dosen Analisis Data...">
                                @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Bidang Keahlian / Expertise</label>
                                <input type="text" name="expertise" class="form-control @error('expertise') is-invalid @enderror" value="{{ old('expertise', $lecturer->expertise) }}" placeholder="Data Mining, Rekayasa Perangkat Lunak...">
                                @error('expertise')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Pendidikan Terakhir</label>
                                <input type="text" name="education" class="form-control @error('education') is-invalid @enderror" value="{{ old('education', $lecturer->education) }}" placeholder="S3 Ilmu Komputer - Universitas Indonesia">
                                @error('education')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="mb-3 text-info border-bottom pb-2">Kontak & Tautan Akademik</h5>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Alamat Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $lecturer->email) }}" placeholder="budi@kampus.ac.id">
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $lecturer->phone) }}">
                                @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label>Google Scholar URL</label>
                                <input type="url" name="google_scholar_url" class="form-control @error('google_scholar_url') is-invalid @enderror" value="{{ old('google_scholar_url', $lecturer->google_scholar_url) }}">
                                @error('google_scholar_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>SINTA URL</label>
                                <input type="url" name="sinta_url" class="form-control @error('sinta_url') is-invalid @enderror" value="{{ old('sinta_url', $lecturer->sinta_url) }}">
                                @error('sinta_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="col-md-4 form-group">
                                <label>Garuda Portal URL</label>
                                <input type="url" name="garuda_url" class="form-control @error('garuda_url') is-invalid @enderror" value="{{ old('garuda_url', $lecturer->garuda_url) }}">
                                @error('garuda_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>LinkedIn Profil</label>
                                <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $lecturer->linkedin_url) }}">
                                @error('linkedin_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Website / Blog Pribadi</label>
                                <input type="url" name="website_url" class="form-control @error('website_url') is-invalid @enderror" value="{{ old('website_url', $lecturer->website_url) }}">
                                @error('website_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 form-group">
                                <h5 class="mb-3 text-info border-bottom pb-2">Biografi Singkat / Deskripsi Diri</h5>
                                <textarea name="biography" class="form-control summernote @error('biography') is-invalid @enderror">{{ old('biography', $lecturer->biography) }}</textarea>
                                @error('biography')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { $('#preview').attr('src', e.target.result); }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@stop
