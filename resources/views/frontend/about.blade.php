@extends('layouts.frontend')

@push('title'){{ __('Detail Profil') }} - @endpush

@push('styles')
<style>
/* ── HERO ── */
.about-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 55%, #1a56a0 100%);
    position: relative;
    overflow: hidden;
    padding: 120px 0 80px;
}
.about-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.about-hero .badge-pill-outline {
    border: 1.5px solid rgba(255,255,255,0.35);
    border-radius: 50px;
    padding: 6px 18px;
    font-size: .78rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: inline-block;
    color: rgba(255,255,255,.85);
    backdrop-filter: blur(4px);
}
.hero-deco {
    position: absolute; right: 0; top: 50%;
    transform: translateY(-50%);
    font-size: 18rem;
    opacity: .04;
    color: #fff;
    pointer-events: none;
}

/* ── SECTIONS ── */
.section-label {
    font-size: .7rem;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    font-weight: 700;
}
.gradient-bar {
    width: 50px; height: 4px;
    background: linear-gradient(90deg, var(--primary,#1a56a0), #60a5fa);
    border-radius: 4px;
    margin: .75rem 0 1.5rem;
}
.about-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 30px rgba(0,0,0,.07);
    border: 1px solid rgba(0,0,0,.05);
    transition: transform .3s, box-shadow .3s;
}
.about-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,.12); }

/* ── LEADER CARD ── */
.leader-photo-wrap {
    width: 110px; height: 110px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #e8f0fe;
    flex-shrink: 0;
    background: #f1f5f9;
}
.leader-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.leader-icon-placeholder {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a56a0, #60a5fa);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.leader-avatar-premium {
    width: 150px;
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    border: 4px solid #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    flex-shrink: 0;
    background: #f1f5f9;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
}
.leader-avatar-premium::after {
    content: '';
    position: absolute;
    inset: 0;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.06);
    border-radius: 12px;
    pointer-events: none;
}
.leader-avatar-premium:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border-color: #3b82f6;
}
.leader-avatar-premium img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}
.leader-avatar-premium:hover img {
    transform: scale(1.08) !important;
}
.leader-placeholder-aurora {
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, #cbd5e1, #94a3b8) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #fff !important;
}
.aurora-leader-name {
    font-size: 1.5rem !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    letter-spacing: -0.5px !important;
    line-height: 1.2 !important;
    margin: 0 !important;
}
.aurora-leader-badge {
    color: #3b82f6 !important;
    font-weight: 700 !important;
    font-size: 0.82rem !important;
    display: inline-flex !important;
    align-items: center !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    margin-top: 6px !important;
}
.aurora-leader-badge p {
    margin: 0 !important;
    display: inline !important;
}
.aurora-tagline {
    font-size: 0.75rem !important;
    letter-spacing: 2.5px !important;
    text-transform: uppercase !important;
    font-weight: 800 !important;
    color: #3b82f6 !important;
    display: block !important;
}
.aurora-greet-title {
    font-weight: 800 !important;
    font-size: 2.6rem !important;
    color: #0f172a !important;
    letter-spacing: -1px !important;
    line-height: 1.1 !important;
}
.aurora-quote-box {
    position: relative !important;
    padding-left: 1.5rem !important;
    border-left: 3px solid #3b82f6 !important;
}
.aurora-quote-icon {
    position: absolute !important;
    left: -1rem !important;
    top: -1.5rem !important;
    font-size: 3rem !important;
    color: #3b82f6 !important;
    opacity: 0.1 !important;
    z-index: -1 !important;
}
.aurora-quote-text {
    font-size: 1.1rem !important;
    color: #4b5563 !important;
    line-height: 1.8 !important;
}
.aurora-btn-link {
    color: #3b82f6 !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    font-size: 0.85rem !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    display: inline-flex !important;
    align-items: center !important;
    transition: all 0.3s !important;
}
.aurora-btn-link:hover {
    color: #2563eb !important;
    transform: translateX(5px) !important;
}

/* ── VISION / MISSION ── */
.vm-card {
    border-radius: 20px;
    padding: 2.5rem;
    height: 100%;
    position: relative;
    overflow: hidden;
}
.vm-card.vision-card {
    background: linear-gradient(135deg, #0f172a, #1e3a5f);
    color: #fff !important;
}
.vm-card.vision-card p,
.vm-card.vision-card span,
.vm-card.vision-card strong,
.vm-card.vision-card font {
    color: #fff !important;
}
.vm-card.mission-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}
.vm-card .vm-icon {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.25rem;
}
.vm-card.vision-card .vm-icon { background: rgba(255,255,255,.12); color: #93c5fd; }
.vm-card.mission-card .vm-icon { background: #e8f0fe; color: #1a56a0; }
.vm-card .deco-circle {
    position: absolute; bottom: -30px; right: -30px;
    width: 150px; height: 150px;
    border-radius: 50%;
    opacity: .06;
    background: #fff;
}

/* ── ACCREDITATION / CERT ── */
.cert-card {
    border-radius: 16px;
    background: #fff;
    border: 1px solid #e2e8f0;
    transition: all .3s;
    overflow: hidden;
}
.cert-card:hover { border-color: #1a56a0; box-shadow: 0 8px 24px rgba(26,86,160,.12); }
.cert-badge {
    background: linear-gradient(135deg, #1a56a0, #3b82f6);
    color: #fff;
    border-radius: 10px 10px 0 0;
    padding: 1rem;
    display: flex; align-items: center; gap: .75rem;
}
.cert-badge i { font-size: 1.4rem; }

/* ── VIDEO ── */
.video-frame-wrap {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    position: relative;
}
.video-frame-wrap::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 60%, rgba(15,23,42,.4));
    z-index: 1; pointer-events: none;
}
</style>
@endpush

@section('content')

{{-- ── HERO (matches static pages) ── --}}
<div class="page-header-premium py-5 text-white position-relative overflow-hidden">
    <div class="page-header-pattern"></div>
    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-up">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 text-white-50">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Detail Profil') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-0">{{ __('Detail Profil') }}</h1>
            </div>
        </div>
    </div>
    <div class="page-header-logo">
        @php 
            $logoWhite = \App\Models\Setting::get('site_logo_white');
            $logoMain = \App\Models\Setting::get('site_logo');
            $displayLogo = (!$logoWhite || $logoWhite == 'images/logo_white.png') ? $logoMain : $logoWhite;
        @endphp
        @if($displayLogo)
            <img src="{{ asset('storage/'.$displayLogo) }}" alt="Logo">
        @endif
    </div>
</div>

{{-- ── ABOUT INSTITUTION (full text) ── --}}
@if($aboutInstitution)
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="fade-up">
                <div class="about-card p-5">
                    <span class="section-label text-primary">{{ __('Detail Institusi') }}</span>
                    <div class="gradient-bar"></div>
                    <p class="text-secondary fs-5 lh-lg mb-0" style="text-align:justify;">
                        @safeHtml($aboutInstitution)
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── STATIC PAGE CONTENT (if any) ── --}}
@if(isset($page) && $page?->content)
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 fs-5 text-secondary" data-aos="fade-up" style="text-align:justify;">
                @safeHtml($page->content)
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── LEADER SAMBUTAN (Aurora Premium Mod) ── --}}
@if($greeting || $headName)
<section class="py-5 aurora-greeting-section" style="background: #fff; overflow:hidden;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="aurora-greeting-card">
                    <span class="aurora-tagline"><i class="fas fa-graduation-cap me-2"></i>{{ __('Sambutan Pimpinan') }}</span>
                    <h2 class="aurora-greet-title mt-2 mb-4">Leadership <span class="text-primary">Vision</span></h2>

                    <div class="d-flex align-items-center gap-4 mb-5">
                        <div class="leader-avatar-premium">
                            @if($kaprodiPhoto)
                                <img src="{{ asset('storage/'.$kaprodiPhoto) }}" alt="{{ $headName }}">
                            @else
                                <div class="leader-placeholder-aurora">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="aurora-leader-name mb-1">{{ $headName }}</h4>
                            <div class="aurora-leader-badge">
                                <i class="fas fa-award me-1"></i>{{ \App\Models\Setting::get('greeting_position', 'Ketua Program Studi') }}
                            </div>
                        </div>
                    </div>

                    <div class="aurora-quote-box position-relative">
                        <i class="fas fa-quote-left aurora-quote-icon"></i>
                        <div class="aurora-quote-text lh-lg" style="text-align:justify;">
                            @safeHtml($greeting)
                        </div>
                        
                        <div class="mt-4 pt-3">
                            <a href="#" class="aurora-btn-link">
                                {{ __('Selengkapnya') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                @if($videoEmbed)
                <div class="aurora-video-container">
                    <div class="aurora-video-glow"></div>
                    <div class="ratio ratio-16x9 aurora-video-frame">
                        <iframe src="{{ $videoEmbed }}" title="Video Profil" allowfullscreen frameborder="0"></iframe>
                    </div>
                </div>
                @else
                <div class="about-card p-5 d-flex flex-column align-items-center justify-content-center text-center" style="min-height:350px; background: #f8fbff; border-radius: 30px;">
                    <div class="icon-play-aurora mb-3">
                        <i class="fas fa-play fa-xl text-white"></i>
                    </div>
                    <p class="text-muted fw-bold mb-0">Video Profil Segera Hadir</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── VISI & MISI ── --}}
@if($vision || $mission)
<section class="py-5" style="background:#f0f4ff;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label text-primary">{{ __('Arah & Tujuan') }}</span>
            <div class="gradient-bar mx-auto" style="margin:auto;"></div>
            <h2 class="fw-bold fs-1">{{ __('Visi & Misi') }}</h2>
        </div>
        <div class="row g-4">
            @if($vision)
            <div class="col-lg-6" data-aos="fade-right">
                <div class="vm-card vision-card h-100">
                    <div class="vm-icon"><i class="fas fa-eye"></i></div>
                    <h3 class="fw-bold mb-3">{{ __('Visi') }}</h3>
                    <p class="opacity-85 lh-lg mb-0" style="text-align:justify;">@safeHtml($vision)</p>
                    <div class="deco-circle"></div>
                </div>
            </div>
            @endif
            @if($mission)
            <div class="col-lg-6" data-aos="fade-left">
                <div class="vm-card mission-card h-100">
                    <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                    <h3 class="fw-bold mb-3 text-dark">{{ __('Misi') }}</h3>
                    <div class="text-secondary lh-lg" style="text-align:justify;">@safeHtml($mission)</div>
                    <div class="deco-circle" style="background:#1a56a0;"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ── AKREDITASI & SERTIFIKASI ── --}}
@if($accreditation || $certAccreditation || count($certOthers) > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label text-primary"><i class="fas fa-certificate me-2"></i>{{ __('Kualitas & Kepercayaan') }}</span>
            <div class="gradient-bar mx-auto" style="margin:auto;"></div>
            <h2 class="fw-bold fs-1">{{ __('Akreditasi & Sertifikasi') }}</h2>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- Akreditasi BAN-PT --}}
            @if($accreditation || $certAccreditation)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="cert-card h-100">
                    <div class="cert-badge">
                        <i class="fas fa-award"></i>
                        <div>
                            <div class="fw-bold">Akreditasi</div>
                            <small class="opacity-75">BAN-PT / LAM</small>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        @if($certAccreditation)
                            @php $ext = pathinfo($certAccreditation, PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','webp']))
                                <img src="{{ asset('storage/'.$certAccreditation) }}" alt="Sertifikat Akreditasi" class="img-fluid rounded mb-3" style="max-height:160px; object-fit:contain;">
                            @else
                                <div class="mb-3 py-3">
                                    <i class="fas fa-file-pdf fa-4x text-danger opacity-75"></i>
                                </div>
                                <a href="{{ asset('storage/'.$certAccreditation) }}" target="_blank" class="btn btn-outline-primary btn-sm mb-3">
                                    <i class="fas fa-eye me-1"></i> Lihat Sertifikat
                                </a>
                            @endif
                        @else
                            <div class="py-3"><i class="fas fa-award fa-4x" style="color:#1a56a0; opacity:.3;"></i></div>
                        @endif
                        @if($accreditation)
                        <div class="fw-bold fs-4 text-primary">{{ $accreditation }}</div>
                        <small class="text-muted">Status Akreditasi</small>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Sertifikasi Lainnya --}}
            @foreach($certOthers as $i => $cert)
            @if(!empty($cert['name']))
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ ($i+2)*100 }}">
                <div class="cert-card h-100">
                    <div class="cert-badge" style="background:linear-gradient(135deg, #334155, #64748b);">
                        <i class="fas fa-certificate"></i>
                        <div>
                            <div class="fw-bold">{{ $cert['name'] }}</div>
                            <small class="opacity-75">Sertifikasi</small>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        @if(!empty($cert['file']))
                            @php $ext2 = pathinfo($cert['file'], PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($ext2), ['jpg','jpeg','png','webp']))
                                <img src="{{ asset('storage/'.$cert['file']) }}" alt="{{ $cert['name'] }}" class="img-fluid rounded mb-3" style="max-height:160px; object-fit:contain;">
                            @else
                                <div class="py-3 mb-2"><i class="fas fa-file-pdf fa-4x text-danger opacity-75"></i></div>
                            @endif
                            <a href="{{ asset('storage/'.$cert['file']) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i> Lihat Dokumen
                            </a>
                        @else
                            <div class="py-3"><i class="fas fa-certificate fa-4x text-secondary opacity-25"></i></div>
                            <p class="text-muted small mb-0">Dokumen tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>
</section>
@endif

@endsection
