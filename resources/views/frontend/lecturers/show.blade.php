@extends('layouts.frontend')

@push('title')
{{ $lecturer->name }} - {{ __('Profil Dosen') }} -
@endpush

@section('content')
<div class="page-header-premium py-5 text-white position-relative overflow-hidden">
    <div class="page-header-pattern"></div>
    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-up">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 text-white-50">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lecturers.index') }}" class="text-white-50">{{ __('Dosen & Tendik') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $lecturer->name }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-0">{{ $lecturer->name }}</h1>
                <p class="lead mb-0 text-white-50 mt-2">{{ $lecturer->academic_title }}</p>
            </div>
        </div>
    </div>
    <div class="page-header-logo">
        @php $logo = \App\Models\Setting::get('site_logo') @endphp
        @if($logo)
            <img src="{{ asset('storage/'.$logo) }}" alt="Logo">
        @endif
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="sticky-top" style="top: 100px;">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <img src="{{ $lecturer->photo_url }}" class="card-img-top" alt="{{ $lecturer->name }}" style="aspect-ratio: 1/1; object-fit: cover;">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-1">{{ $lecturer->name }}</h5>
                            <p class="text-primary mb-3">{{ $lecturer->position ?? __('Dosen') }}</p>
                            
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                @if($lecturer->email)
                                <a href="mailto:{{ $lecturer->email }}" class="btn btn-primary btn-sm rounded-circle shadow-sm" title="Email"><i class="fas fa-envelope m-1"></i></a>
                                @endif
                                @if($lecturer->google_scholar_url)
                                <a href="{{ $lecturer->google_scholar_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" title="Google Scholar"><i class="fas fa-graduation-cap m-1"></i></a>
                                @endif
                                @if($lecturer->linkedin_url)
                                <a href="{{ $lecturer->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" title="LinkedIn"><i class="fab fa-linkedin-in m-1"></i></a>
                                @endif
                                @if($lecturer->website_url)
                                <a href="{{ $lecturer->website_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" title="Website"><i class="fas fa-globe m-1"></i></a>
                                @endif
                            </div>

                            <div class="border-top pt-3 text-start small text-secondary">
                                <div class="mb-2"><i class="fas fa-id-badge me-2 text-primary"></i> <strong>NIP:</strong> {{ $lecturer->nip ?? '-' }}</div>
                                <div class="mb-0"><i class="fas fa-id-card-alt me-2 text-primary"></i> <strong>NIDN:</strong> {{ $lecturer->nidn ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">{{ __('Profil & Biografi') }}</h4>
                    <div class="text-secondary mb-4 leading-relaxed">
                        @safeHtml($lecturer->biography ?: __('Biografi belum tersedia.'))
                    </div>

                    <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">{{ __('Informasi Akademik') }}</h4>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark"><i class="fas fa-microscope text-primary me-2"></i>{{ __('Bidang Keahlian') }}</h6>
                            <p class="text-secondary small">{{ $lecturer->expertise ?: '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark"><i class="fas fa-university text-primary me-2"></i>{{ __('Jabatan Fungsional') }}</h6>
                            <p class="text-secondary small">{{ $lecturer->functional_position ?: '-' }}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="fw-bold text-dark"><i class="fas fa-graduation-cap text-primary me-2"></i>{{ __('Riwayat Pendidikan') }}</h6>
                            <div class="text-secondary small">
                                {!! nl2br(e($lecturer->education)) ?: '-' !!}
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">{{ __('Publikasi & Riset') }}</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <a href="{{ $lecturer->sinta_url }}" target="_blank" class="d-block p-3 border rounded-3 text-center text-decoration-none transition-hover">
                                <h6 class="fw-bold mb-0 text-dark">SINTA</h6>
                                <small class="text-muted">ID: {{ last(explode('/', rtrim($lecturer->sinta_url, '/'))) ?: '-' }}</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ $lecturer->garuda_url }}" target="_blank" class="d-block p-3 border rounded-3 text-center text-decoration-none transition-hover">
                                <h6 class="fw-bold mb-0 text-dark">GARUDA</h6>
                                <small class="text-muted">ID: {{ last(explode('/', rtrim($lecturer->garuda_url, '/'))) ?: '-' }}</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ $lecturer->google_scholar_url }}" target="_blank" class="d-block p-3 border rounded-3 text-center text-decoration-none transition-hover">
                                <h6 class="fw-bold mb-0 text-dark">SCOPUS</h6>
                                <small class="text-muted">Author ID</small>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="{{ route('lecturers.index') }}" class="btn btn-outline-primary rounded-pill px-5">
                        <i class="fas fa-arrow-left me-2"></i> {{ __('Kembali ke Daftar Dosen') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .rotate-n-15 { transform: rotate(-15deg); }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { background-color: var(--bs-light); border-color: var(--bs-primary) !important; transform: translateY(-2px); }
    .leading-relaxed { line-height: 1.8; }
</style>
@endpush
