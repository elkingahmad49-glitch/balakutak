@extends('layouts.frontend')

@push('title')
{{ __('Pendidikan') }} -
@endpush

@section('content')
<div class="page-header-premium py-5 text-white position-relative overflow-hidden mb-5">
    <div class="page-header-pattern"></div>
    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 text-white-50">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Pendidikan') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-0">{{ __('Pendidikan') }}</h1>
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
        <div class="row g-4 justify-content-center">
            {{-- Card 1: Kurikulum --}}
            <div class="col-xl-3 col-md-6" data-aos="fade-up">
                <div class="card academic-card border-0 h-100 p-4 accent-blue">
                    <div class="card-body text-center d-flex flex-column justify-content-between p-0">
                        <div class="mb-4">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h4 class="fw-bold mb-3 card-title-text">{{ __('Kurikulum') }}</h4>
                            <p class="text-secondary small mb-0">{{ __('Kurikulum yang disusun berdasarkan standar kompetensi industri dan kebutuhan pasar global.') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('curriculum') }}" class="btn btn-action rounded-pill px-4 w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Kalender Akademik --}}
            <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card academic-card border-0 h-100 p-4 accent-green">
                    <div class="card-body text-center d-flex flex-column justify-content-between p-0">
                        <div class="mb-4">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h4 class="fw-bold mb-3 card-title-text">{{ __('Kalender Akademik') }}</h4>
                            <p class="text-secondary small mb-0">{{ __('Informasi mengenai jadwal perkuliahan, ujian, dan kegiatan akademik lainnya.') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('calendar') }}" class="btn btn-action rounded-pill px-4 w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Sistem & Layanan --}}
            <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card academic-card border-0 h-100 p-4 accent-gold">
                    <div class="card-body text-center d-flex flex-column justify-content-between p-0">
                        <div class="mb-4">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h4 class="fw-bold mb-3 card-title-text">{{ __('Sistem & Layanan') }}</h4>
                            <p class="text-secondary small mb-0">{{ __('Akses layanan digital terpadu untuk mendukung kegiatan akademik Anda.') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('academic-services') }}" class="btn btn-action rounded-pill px-4 w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4: Prosedur & Form --}}
            <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card academic-card border-0 h-100 p-4 accent-purple">
                    <div class="card-body text-center d-flex flex-column justify-content-between p-0">
                        <div class="mb-4">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h4 class="fw-bold mb-3 card-title-text">{{ __('Prosedur & Form') }}</h4>
                            <p class="text-secondary small mb-0">{{ __('Akses dokumen dan prosedur pengajuan surat keterangan, skripsi, dan layanan lainnya.') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('documents') }}" class="btn btn-action rounded-pill px-4 w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Academic Cards Style System */
    .academic-card {
        border-radius: 20px;
        background: #f8fafc;
        border: 1px solid rgba(0, 0, 0, 0.03) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }
    
    .academic-card .card-body {
        position: relative;
        z-index: 2;
    }
    
    .academic-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 4px;
        transition: height 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .academic-card .icon-box {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        background: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        transition: all 0.4s ease;
    }

    .academic-card .card-title-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        transition: color 0.3s ease;
    }
    
    .academic-card .btn-action {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.825rem;
        font-weight: 700;
        background: transparent;
        border: 1px solid #cbd5e1;
        color: #475569;
        transition: all 0.3s ease;
    }

    /* Accent Coloring */
    
    /* Blue (Kurikulum) */
    .accent-blue::before { background: #2563eb; }
    .accent-blue .icon-box { color: #2563eb; }
    .accent-blue:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.12) !important;
        border-color: rgba(37, 99, 235, 0.15) !important;
    }
    .accent-blue:hover::before { height: 8px; }
    .accent-blue:hover .icon-box {
        background: #2563eb;
        color: #ffffff;
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);
    }
    .accent-blue:hover .btn-action {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
    }

    /* Green (Kalender) */
    .accent-green::before { background: #10b981; }
    .accent-green .icon-box { color: #10b981; }
    .accent-green:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.12) !important;
        border-color: rgba(16, 185, 129, 0.15) !important;
    }
    .accent-green:hover::before { height: 8px; }
    .accent-green:hover .icon-box {
        background: #10b981;
        color: #ffffff;
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
    }
    .accent-green:hover .btn-action {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2);
    }

    /* Gold (Layanan) */
    .accent-gold::before { background: #d97706; }
    .accent-gold .icon-box { color: #d97706; }
    .accent-gold:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(217, 119, 6, 0.12) !important;
        border-color: rgba(217, 119, 6, 0.15) !important;
    }
    .accent-gold:hover::before { height: 8px; }
    .accent-gold:hover .icon-box {
        background: #d97706;
        color: #ffffff;
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 10px 25px rgba(217, 119, 6, 0.25);
    }
    .accent-gold:hover .btn-action {
        background: #d97706;
        border-color: #d97706;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(217, 119, 6, 0.2);
    }

    /* Purple (Prosedur) */
    .accent-purple::before { background: #6366f1; }
    .accent-purple .icon-box { color: #6366f1; }
    .accent-purple:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.12) !important;
        border-color: rgba(99, 102, 241, 0.15) !important;
    }
    .accent-purple:hover::before { height: 8px; }
    .accent-purple:hover .icon-box {
        background: #6366f1;
        color: #ffffff;
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.25);
    }
    .accent-purple:hover .btn-action {
        background: #6366f1;
        border-color: #6366f1;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(99, 102, 241, 0.2);
    }

    /* Dark Mode Support */
    .dark .academic-card {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }
    .dark .academic-card .icon-box {
        background: #0f172a;
        box-shadow: none;
    }
    .dark .academic-card .card-title-text {
        color: #f8fafc;
    }
    .dark .academic-card .text-secondary {
        color: #94a3b8 !important;
    }
    .dark .academic-card .btn-action {
        border-color: #475569;
        color: #cbd5e1;
    }
</style>
@endpush
