@extends('layouts.frontend')

@push('title'){{ __('Layanan Akademik') }} - @endpush

@section('content')
<div class="page-header-premium py-5 text-white position-relative overflow-hidden mb-0">
    <div class="page-header-pattern"></div>
    <div class="container py-4 position-relative z-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 text-white-50">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Layanan Akademik') }}</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-0">{{ __('Sistem & Layanan') }}</h1>
    </div>
    <div class="page-header-logo">
        <img src="{{ asset('storage/'.\App\Models\Setting::get('site_logo')) }}" alt="Logo">
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container">
        <!-- Filter Bar -->
        <div class="filter-card shadow-sm mb-5 p-4 rounded-4 bg-white border border-light">
            <form action="{{ route('academic-services') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1">Cari Layanan / Aplikasi</label>
                    <div class="input-group search-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-warning"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Ketik nama layanan atau deskripsi..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-warning rounded-pill fw-bold py-2 shadow-sm text-dark">
                        <i class="fas fa-filter me-2 opacity-50"></i> Filter Layanan
                    </button>
                </div>
                @if(request('q'))
                <div class="col-12 mt-2 text-center">
                    <a href="{{ route('academic-services') }}" class="text-danger small fw-bold text-decoration-none">
                        <i class="fas fa-times-circle me-1"></i> Reset Filter
                    </a>
                </div>
                @endif
            </form>
        </div>

        <div class="table-responsive shadow-lg rounded-4 overflow-hidden border-0">
            <table class="table table-hover align-middle mb-0 custom-datatable">
                <thead class="bg-dark bg-gradient text-white">
                    <tr>
                        <th class="px-4 py-4" style="width: 40%;">Nama Layanan</th>
                        <th class="py-4">Deskripsi Singkat</th>
                        <th class="px-4 py-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($services as $service)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 bg-light text-warning shadow-sm d-flex align-items-center justify-content-center">
                                    @if($service->icon && (Str::contains($service->icon, '/') || Str::contains($service->icon, '.')))
                                        <img src="{{ asset('storage/' . $service->icon) }}" alt="icon" style="max-height: 28px; max-width: 28px; object-fit: contain;">
                                    @else
                                        <i class="{{ $service->icon ?: 'fas fa-link' }}"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-dark fw-bold" style="font-size: 1rem;">{{ $service->title }}</div>
                                    <small class="text-muted text-uppercase letter-spacing-1" style="font-size: 0.65rem;">Sistem Informasi</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <p class="text-secondary small mb-0 line-clamp-2" style="max-width: 500px;">
                                {{ $service->description ?: 'Akses layanan digital terpadu untuk mendukung kegiatan akademik anda.' }}
                            </p>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ $service->url }}" target="{{ $service->is_external ? '_blank' : '_self' }}" class="btn btn-sm btn-gold rounded-pill px-4 hover-up shadow-sm">
                                Buka Aplikasi <i class="fas fa-external-link-alt ms-2 small"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-laptop-code fa-3x text-muted opacity-20 mb-3"></i>
                                <h5 class="text-muted fw-bold">Tidak ada layanan ditemukan.</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $services->links() }}
        </div>
        
        <!-- Helpdesk Card -->
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg rounded-4 p-5 text-white overflow-hidden position-relative" style="background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d); border-radius: 20px;">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="fas fa-headset fa-10x text-white"></i>
                    </div>
                    <div class="row align-items-center position-relative z-1">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-3 text-white">Kendala Saat Mengakses Layanan?</h3>
                            <p class="lead mb-0 text-white-50">Jika Anda mengalami kendala teknis (Lupa Password, Akun Terkunci, dll.), silakan hubungi Unit Helpdesk Teknologi Informasi.</p>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                            <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow fw-bold text-dark">
                                <i class="fas fa-comments me-2 text-dark opacity-50"></i> Hubungi Helpdesk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .filter-card { border-radius: 20px; transition: all 0.3s ease; }
    .filter-card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08) !important; }
    .custom-datatable thead th { font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; border: none; }
    .custom-datatable tbody td { border-color: #f8f9fa; }
    .icon-box { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .hover-up { transition: all 0.2s ease; }
    .hover-up:hover { transform: translateY(-2px); }
    .input-group.search-group input { border-radius: 0 12px 12px 0 !important; border-color: #eee; }
    .input-group.search-group .input-group-text { border-radius: 12px 0 0 12px !important; border-color: #eee; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bg-navy-gradient { background: linear-gradient(135deg, #0a192f 0%, #112240 100%); }
    .btn-gold { background: #ffc107; color: #000; font-weight: 700; border: none; }
    .btn-gold:hover { background: #e0a800; color: #000; }
</style>
@endpush
