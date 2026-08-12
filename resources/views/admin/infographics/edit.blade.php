@extends('adminlte::page')

@section('title', 'Edit Info Grafis')

@section('content_header')
    <h1><i class="fas fa-edit me-2"></i>Edit Info Grafis</h1>
@stop

@section('content')
<div class="container-fluid pt-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm mb-0">
                <div class="card-body py-3 border-left border-primary" style="border-width: 4px !important;">
                    <h3 class="card-title m-0 font-weight-bold text-primary"><i class="fas fa-edit me-2"></i>Edit Info Grafis: {{ $infographic->title }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Groups -->
        <div class="col-md-3">
            @include('admin.settings._sidebar')
        </div>

        <!-- Form Content -->
        <div class="col-md-9">
            <div class="card card-primary card-outline shadow-sm border-0" style="border-radius: 12px;">
            <form action="{{ route('admin.infographics.update', $infographic) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label font-weight-bold">Judul Data Info Grafis <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control form-control-lg bg-light border-0 @error('title') is-invalid @enderror" value="{{ old('title', $infographic->title) }}" placeholder="Contoh: Info Grafis 2024 atau Data 2023/2024" required style="border-radius: 8px;">
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-ol mr-2"></i>Data Statistik</h5>
                            <button type="button" class="btn btn-sm btn-success shadow-xs" onclick="addStatRow()">
                                <i class="fas fa-plus mr-1"></i> Tambah Field
                            </button>
                        </div>
                        <div id="stats_container" class="bg-light p-4 rounded" style="border: 2px dashed #e2e8f0;">
                            @php
                                $stats = old('stats_labels') ? array_map(function($label, $index) {
                                    return ['label' => $label, 'value' => old('stats_values')[$index] ?? 0];
                                }, old('stats_labels'), array_keys(old('stats_labels'))) : ($infographic->stats ?? []);
                            @endphp

                            @forelse($stats as $index => $stat)
                                <div class="row stat-row mb-3 animated fadeIn">
                                    <div class="col-md-7">
                                        <input type="text" name="stats_labels[]" class="form-control border-0 shadow-xs" placeholder="Nama Label (e.g. Total Mahasiswa)" value="{{ $stat['label'] ?? '' }}" required style="border-radius: 6px;">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="stats_values[]" class="form-control border-0 shadow-xs" placeholder="Nilai" value="{{ $stat['value'] ?? 0 }}" required min="0" style="border-radius: 6px;">
                                    </div>
                                    <div class="col-md-1 text-right pt-2">
                                        @if($loop->index > 0)
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="removeStatRow(this)"><i class="fas fa-minus-circle fa-lg"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="row stat-row mb-3">
                                    <div class="col-md-7">
                                        <input type="text" name="stats_labels[]" class="form-control border-0 shadow-xs" placeholder="Nama Label (e.g. Total Mahasiswa)" required style="border-radius: 6px;">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="stats_values[]" class="form-control border-0 shadow-xs" placeholder="Nilai" required min="0" style="border-radius: 6px;">
                                    </div>
                                    <div class="col-md-1 text-right pt-2">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0 bg-light p-3 rounded-lg border">
                        <div class="col-sm-12">
                            <div class="custom-control custom-switch custom-switch-md">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $infographic->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="is_active">Status Aktif di Beranda</label>
                            </div>
                            <small class="form-text text-warning mt-2"><i class="fas fa-info-circle mr-1"></i> Jika diaktifkan, data info grafis lainnya akan otomatis dinonaktifkan.</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top p-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.infographics.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@push('js')
<script>
    function addStatRow() {
        const container = document.getElementById('stats_container');
        const newRow = document.createElement('div');
        newRow.className = 'row stat-row mb-3 animated fadeIn';
        newRow.innerHTML = `
            <div class="col-md-7">
                <input type="text" name="stats_labels[]" class="form-control border-0 shadow-xs" placeholder="Nama Label (e.g. Total Mahasiswa)" required style="border-radius: 6px;">
            </div>
            <div class="col-md-4">
                <input type="number" name="stats_values[]" class="form-control border-0 shadow-xs" placeholder="Nilai" required min="0" style="border-radius: 6px;">
            </div>
            <div class="col-md-1 text-right pt-2">
                <button type="button" class="btn btn-link text-danger p-0" onclick="removeStatRow(this)"><i class="fas fa-minus-circle fa-lg"></i></button>
            </div>
        `;
        container.appendChild(newRow);
    }

    function removeStatRow(btn) {
        const row = btn.closest('.stat-row');
        row.classList.add('fadeOut');
        setTimeout(() => row.remove(), 250);
    }
</script>
<style>
    .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .custom-switch-md .custom-control-label::before { height: 1.5rem; width: 2.75rem; border-radius: 3rem; }
    .custom-switch-md .custom-control-label::after { width: calc(1.5rem - 4px); height: calc(1.5rem - 4px); border-radius: 3.5rem; }
    .custom-switch-md .custom-control-input:checked~.custom-control-label::after { transform: translateX(1.25rem); }
    .animated { animation-duration: 0.3s; fill-mode: both; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; transform: translateY(-10px); } }
    .fadeIn { animation-name: fadeIn; }
    .fadeOut { animation-name: fadeOut; }
</style>
@endpush
@stop
