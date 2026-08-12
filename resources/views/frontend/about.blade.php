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

/* ── ACCREDITATION / CERT PREMIUM STYLE ── */
.cert-card {
    border-radius: 20px;
    background: #fff;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    overflow: hidden;
    position: relative;
}
.cert-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(26, 86, 160, 0.15);
}
.cert-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 3px solid #3b82f6;
    transition: all 0.3s ease;
}
.cert-card:hover .cert-header {
    border-bottom-color: #60a5fa;
}
.cert-header i {
    font-size: 1.8rem;
    color: #60a5fa;
}
.cert-preview-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    margin: 1.5rem auto;
    width: 90%;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.cert-preview-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}
.cert-preview-container:hover img {
    transform: scale(1.05);
}
.cert-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2;
}
.cert-preview-container:hover .cert-overlay {
    opacity: 1;
}
.cert-action-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.4);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
}
.cert-action-btn:hover {
    background: #fff;
    color: #1a56a0;
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}
.cert-pdf-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
}
.cert-pdf-placeholder i {
    font-size: 3.5rem;
    color: #ef4444;
}
.cert-buttons-group {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}
.cert-btn-primary {
    flex: 1;
    background: #1a56a0;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
}
.cert-btn-primary:hover {
    background: #11427d;
    color: #fff;
    box-shadow: 0 4px 12px rgba(26, 86, 160, 0.2);
}
.cert-btn-secondary {
    flex: 1;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 30px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
}
.cert-btn-secondary:hover {
    background: #e2e8f0;
    color: #1e293b;
}

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
            @php 
                $fileUrl = $certAccreditation ? asset('storage/'.$certAccreditation) : '#';
                $ext = $certAccreditation ? pathinfo($certAccreditation, PATHINFO_EXTENSION) : '';
                $isImage = in_array(strtolower($ext), ['jpg','jpeg','png','webp']);
                $fileType = $isImage ? 'image' : (strtolower($ext) === 'pdf' ? 'pdf' : 'unknown');
            @endphp
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="cert-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="cert-header">
                            <i class="fas fa-award"></i>
                            <div>
                                <div class="fw-bold">Akreditasi</div>
                                <small class="opacity-75">BAN-PT / LAM</small>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            @if($certAccreditation)
                                <div class="cert-preview-container shadow-sm">
                                    @if($isImage)
                                        <img src="{{ $fileUrl }}" alt="Sertifikat Akreditasi" class="img-fluid rounded">
                                    @else
                                        <div class="cert-pdf-placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                            <span class="fw-bold text-sm text-dark mt-2">Dokumen PDF</span>
                                            <span class="text-xs text-muted">Pratinjau Tersedia</span>
                                        </div>
                                    @endif
                                    <div class="cert-overlay">
                                        <button type="button" class="cert-action-btn" data-bs-toggle="modal" data-bs-target="#certViewerModal" data-file-url="{{ $fileUrl }}" data-file-name="Sertifikat Akreditasi BAN-PT" data-file-type="{{ $fileType }}" title="Pratinjau">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ $fileUrl }}" download class="cert-action-btn" title="Unduh">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="py-5 text-center">
                                    <i class="fas fa-award fa-4x mb-3" style="color:#1a56a0; opacity:.15;"></i>
                                    <p class="text-muted small">File sertifikat belum diunggah</p>
                                </div>
                            @endif
                            
                            @if($accreditation)
                            <div class="fw-bold fs-4 text-primary mt-2">{{ $accreditation }}</div>
                            <small class="text-muted d-block mb-3">Status Akreditasi</small>
                            @endif
                        </div>
                    </div>
                    @if($certAccreditation)
                    <div class="px-4 pb-4">
                        <div class="cert-buttons-group">
                            <button type="button" class="cert-btn-primary" data-bs-toggle="modal" data-bs-target="#certViewerModal" data-file-url="{{ $fileUrl }}" data-file-name="Sertifikat Akreditasi BAN-PT" data-file-type="{{ $fileType }}">
                                <i class="fas fa-eye"></i> {{ __('Lihat') }}
                            </button>
                            <a href="{{ $fileUrl }}" download class="cert-btn-secondary">
                                <i class="fas fa-download"></i> {{ __('Unduh') }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Sertifikasi Lainnya --}}
            @foreach($certOthers as $i => $cert)
            @if(!empty($cert['name']))
            @php 
                $otherFileUrl = !empty($cert['file']) ? asset('storage/'.$cert['file']) : '#';
                $ext2 = !empty($cert['file']) ? pathinfo($cert['file'], PATHINFO_EXTENSION) : '';
                $isImage2 = in_array(strtolower($ext2), ['jpg','jpeg','png','webp']);
                $fileType2 = $isImage2 ? 'image' : (strtolower($ext2) === 'pdf' ? 'pdf' : 'unknown');
            @endphp
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ ($i+2)*100 }}">
                <div class="cert-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="cert-header" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-bottom-color: #64748b;">
                            <i class="fas fa-certificate" style="color: #94a3b8;"></i>
                            <div>
                                <div class="fw-bold">{{ $cert['name'] }}</div>
                                <small class="opacity-75">Sertifikasi</small>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            @if(!empty($cert['file']))
                                <div class="cert-preview-container shadow-sm">
                                    @if($isImage2)
                                        <img src="{{ $otherFileUrl }}" alt="{{ $cert['name'] }}" class="img-fluid rounded">
                                    @else
                                        <div class="cert-pdf-placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                            <span class="fw-bold text-sm text-dark mt-2">Pratinjau PDF</span>
                                            <span class="text-xs text-muted">Pratinjau Tersedia</span>
                                        </div>
                                    @endif
                                    <div class="cert-overlay">
                                        <button type="button" class="cert-action-btn" data-bs-toggle="modal" data-bs-target="#certViewerModal" data-file-url="{{ $otherFileUrl }}" data-file-name="{{ $cert['name'] }}" data-file-type="{{ $fileType2 }}" title="Pratinjau">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ $otherFileUrl }}" download class="cert-action-btn" title="Unduh">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="py-5 text-center">
                                    <i class="fas fa-certificate fa-4x mb-3" style="color:#64748b; opacity:.15;"></i>
                                    <p class="text-muted small">File sertifikasi belum diunggah</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($cert['file']))
                    <div class="px-4 pb-4">
                        <div class="cert-buttons-group">
                            <button type="button" class="cert-btn-primary" style="background:#475569;" data-bs-toggle="modal" data-bs-target="#certViewerModal" data-file-url="{{ $otherFileUrl }}" data-file-name="{{ $cert['name'] }}" data-file-type="{{ $fileType2 }}">
                                <i class="fas fa-eye"></i> {{ __('Lihat') }}
                            </button>
                            <a href="{{ $otherFileUrl }}" download class="cert-btn-secondary">
                                <i class="fas fa-download"></i> {{ __('Unduh') }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>
</section>
@endif

<!-- Modal Viewer untuk Sertifikat -->
<div class="modal fade" id="certViewerModal" tabindex="-1" aria-labelledby="certViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <div class="modal-header border-0 bg-light py-3 px-4 d-flex align-items-center justify-content-between">
                <h5 class="modal-title fw-bold text-dark" id="certViewerModalLabel">Pratinjau Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="box-shadow: none;"></button>
            </div>
            <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center" style="min-height: 400px; max-height: 80vh; overflow: auto;">
                <div id="certViewerContent" class="w-100 h-100 d-flex align-items-center justify-content-center p-3">
                    <!-- Dinamis via Javascript -->
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-bold" id="certViewerFooterName">Nama Dokumen</span>
                <a href="#" id="certViewerDownloadBtn" download class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm">
                    <i class="fas fa-download me-1"></i> Unduh Dokumen
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const certViewerModal = document.getElementById('certViewerModal');
        if (certViewerModal) {
            certViewerModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const fileUrl = button.getAttribute('data-file-url');
                const fileName = button.getAttribute('data-file-name');
                const fileType = button.getAttribute('data-file-type');
                
                const contentContainer = document.getElementById('certViewerContent');
                const footerName = document.getElementById('certViewerFooterName');
                const downloadBtn = document.getElementById('certViewerDownloadBtn');
                
                // Set footer name and download link
                footerName.textContent = fileName;
                downloadBtn.setAttribute('href', fileUrl);
                
                // Clear content first
                contentContainer.innerHTML = '<div class="text-white py-5"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';
                
                if (fileType === 'pdf') {
                    contentContainer.innerHTML = `<iframe src="${fileUrl}" class="w-100" style="height: 70vh; border: none; border-radius: 8px;"></iframe>`;
                } else {
                    contentContainer.innerHTML = `<img src="${fileUrl}" alt="${fileName}" class="img-fluid" style="max-height: 70vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">`;
                }
            });
        }
    });
</script>
@endpush

@endsection
