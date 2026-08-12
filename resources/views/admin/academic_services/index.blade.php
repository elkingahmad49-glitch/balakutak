@extends('adminlte::page')

@section('title', 'Layanan Akademik')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1><i class="fas fa-links mr-2"></i>Layanan Akademik</h1>
        <a href="{{ route('admin.academic-services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Layanan
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 50px" class="text-center">#</th>
                            <th>Layanan</th>
                            <th>Icon</th>
                            <th>URL / Link</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Status</th>
                            <th style="width: 150px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $service->title }}</div>
                                    <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                </td>
                                <td class="text-center">
                                    @if($service->icon && (Str::contains($service->icon, '/') || Str::contains($service->icon, '.')))
                                        <img src="{{ asset('storage/' . $service->icon) }}" alt="icon" style="max-height: 25px; max-width: 25px; object-fit: contain;">
                                    @else
                                        <i class="{{ $service->icon ?: 'fas fa-link' }} fa-lg text-primary"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $service->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 250px;">
                                        {{ $service->url }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if($service->is_external)
                                        <span class="badge badge-info">Eksternal</span>
                                    @else
                                        <span class="badge badge-secondary">Internal</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($service->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Non-aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.academic-services.edit', $service) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.academic-services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada layanan akademik yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
