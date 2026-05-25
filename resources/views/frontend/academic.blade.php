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

<section class="py-5 academic-section">
    <div class="container py-3">
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
    /* Academic Section Layout & Patterns */
    .academic-section {
        background: radial-gradient(circle at 10% 20%, rgba(241, 245, 249, 0.9) 0%, rgba(248, 250, 252, 0.9) 90%);
        position: relative;
    }
    
    .academic-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(#cbd5e1 1.2px, transparent 1.2px);
        background-size: 24px 24px;
        opacity: 0.35;
        pointer-events: none;
        z-index: 0;
    }
    
    .academic-section .container {
        position: relative;
        z-index: 1;
    }

    /* Academic Cards Glassmorphism Style System */
    .academic-card {
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.6) !important;
        box-shadow: 0 12px 36px rgba(15, 23, 42, 0.03) !important;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    
    .academic-card .card-body {
        position: relative;
        z-index: 2;
    }
    
    /* Sliding Sheen Highlight Effect */
    .academic-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 150%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        transform: skewX(-20deg);
        z-index: 1;
        transition: none;
    }
    
    .academic-card:hover::after {
        left: 150%;
        transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    /* Top horizontal color bar */
    .academic-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 3;
    }
    
    /* Elegant Icon Boxes */
    .academic-card .icon-box {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .academic-card .card-title-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        transition: color 0.3s ease;
    }
    
    .academic-card .btn-action {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        background: transparent;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
    }

    /* Accent Design Systems */
    
    /* Blue Accent (Kurikulum) */
    .accent-blue::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .accent-blue .icon-box { color: #2563eb; background: rgba(59, 130, 246, 0.06); }
    .accent-blue:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(37, 99, 235, 0.15) !important;
        border-color: rgba(37, 99, 235, 0.25) !important;
    }
    .accent-blue:hover::before { height: 8px; }
    .accent-blue:hover .icon-box {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #ffffff;
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
    }
    .accent-blue:hover .btn-action {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
    }

    /* Green Accent (Kalender) */
    .accent-green::before { background: linear-gradient(90deg, #10b981, #047857); }
    .accent-green .icon-box { color: #10b981; background: rgba(16, 185, 129, 0.06); }
    .accent-green:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15) !important;
        border-color: rgba(16, 185, 129, 0.25) !important;
    }
    .accent-green:hover::before { height: 8px; }
    .accent-green:hover .icon-box {
        background: linear-gradient(135deg, #10b981, #047857);
        color: #ffffff;
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }
    .accent-green:hover .btn-action {
        background: linear-gradient(90deg, #10b981, #047857);
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25);
    }

    /* Gold Accent (Sistem & Layanan) */
    .accent-gold::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .accent-gold .icon-box { color: #d97706; background: rgba(245, 158, 11, 0.06); }
    .accent-gold:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(217, 119, 6, 0.15) !important;
        border-color: rgba(217, 119, 6, 0.25) !important;
    }
    .accent-gold:hover::before { height: 8px; }
    .accent-gold:hover .icon-box {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #ffffff;
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 15px 30px rgba(217, 119, 6, 0.3);
    }
    .accent-gold:hover .btn-action {
        background: linear-gradient(90deg, #f59e0b, #d97706);
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(217, 119, 6, 0.25);
    }

    /* Purple Accent (Prosedur & Form) */
    .accent-purple::before { background: linear-gradient(90deg, #8b5cf6, #6366f1); }
    .accent-purple .icon-box { color: #6366f1; background: rgba(99, 102, 241, 0.06); }
    .accent-purple:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(99, 102, 241, 0.15) !important;
        border-color: rgba(99, 102, 241, 0.25) !important;
    }
    .accent-purple:hover::before { height: 8px; }
    .accent-purple:hover .icon-box {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: #ffffff;
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
    }
    .accent-purple:hover .btn-action {
        background: linear-gradient(90deg, #8b5cf6, #6366f1);
        border-color: transparent;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.25);
    }

    /* Dark Mode Premium Theme Support */
    .dark .academic-section {
        background: radial-gradient(circle at 10% 20%, #0f172a 0%, #020617 90%);
    }
    .dark .academic-section::before {
        background-image: radial-gradient(#334155 1.2px, transparent 1.2px);
        opacity: 0.25;
    }
    .dark .academic-card {
        background: rgba(30, 41, 59, 0.7);
        border-color: rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.3) !important;
    }
    .dark .academic-card::after {
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.15),
            transparent
        );
    }
    .dark .academic-card .icon-box {
        background: rgba(15, 23, 42, 0.6);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
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
    .dark .accent-blue .icon-box { color: #60a5fa; }
    .dark .accent-green .icon-box { color: #34d399; }
    .dark .accent-gold .icon-box { color: #fbbf24; }
    .dark .accent-purple .icon-box { color: #a78bfa; }
</style>
@endpush
