@extends('layouts.frontend')

@push('title'){{ \App\Models\Setting::get('site_name') }} - @endpush

@section('content')

    {{-- ANNOUNCEMENT BAR (Moved to top above slider) --}}
    @include('frontend.partials.announcement-bar')

    {{-- HERO SLIDER --}}
    @php 
        $siteTheme = \App\Models\Setting::get('site_theme', 'navy-blue-balakutak'); 
        $premiumThemes = [
            'oxford-luxury-balakutak',
            'oxford-luxury-navygold-balakutak',
            'oxford-luxury-redgold-balakutak',
            'oxford-luxury-greengold-balakutak',
            'oxford-luxury-blackgold-balakutak',
            'oxford-luxury-browngold-balakutak',
            'swiss-minimalist-balakutak',
            'emerald-velvet-balakutak',
            'nordic-slate-balakutak',
            'midnight-gold-balakutak'
        ];
        $isPremium = in_array($siteTheme, $premiumThemes) || str_contains($siteTheme, 'oxford-luxury');
        $isAurora = ($siteTheme == 'aurora-glass-balakutak');
    @endphp

    @if($isAurora)
        {{-- AURORA HERO: Full-bleed elegant split layout --}}
        <section class="aurora-hero">
            {{-- LEFT: Text Swiper (synced with image swiper) --}}
            <div class="aurora-hero-left">
                <div class="swiper aurora-text-swiper">
                    <div class="swiper-wrapper">
                        @forelse($sliders as $i => $slider)
                            <div class="swiper-slide">
                                <h1 class="aurora-title">{{ $slider->title }}</h1>
                                <p class="aurora-desc">{{ $slider->subtitle }}</p>
                                <a href="{{ $slider->button_url ?? route('about') }}" class="aurora-cta">
                                    {{ $slider->button_text ?? __('Selengkapnya') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <h1 class="aurora-title">{{ \App\Models\Setting::get('site_name') }}</h1>
                                <p class="aurora-desc">{{ \App\Models\Setting::get('site_tagline') }}</p>
                                <a href="{{ route('about') }}" class="aurora-cta">
                                    {{ __('Selengkapnya') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- Dot navigation --}}
                @if($sliders->count() > 1)
                    <div class="aurora-dots">
                        @foreach($sliders as $i => $s)
                            <span class="aurora-dot {{ $i==0 ? 'active' : '' }}" data-idx="{{ $i }}"></span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- RIGHT: Image Panel with Swiper --}}
            <div class="aurora-hero-right">
                <div class="swiper aurora-swiper">
                    <div class="swiper-wrapper">
                        @forelse($sliders as $slider)
                            @php
                                $sImg = $slider->image;
                                $imgPath = null;

                                // If path is empty, use fallback
                                if (!$sImg) {
                                    $imgPath = 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2670&auto=format&fit=crop';
                                } else {
                                    // Check direct path in storage
                                    if (file_exists(public_path('storage/' . $sImg))) {
                                        $imgPath = asset('storage/' . $sImg);
                                    } 
                                    // Check if it's missing 'media/' prefix but exists there
                                    elseif (file_exists(public_path('storage/media/' . $sImg))) {
                                        $imgPath = asset('storage/media/' . $sImg);
                                    }
                                    // Fallback to Unsplash
                                    else {
                                        $imgPath = 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2670&auto=format&fit=crop';
                                    }
                                }
                            @endphp
                            <div class="swiper-slide">
                                <img src="{{ $imgPath }}" alt="{{ $slider->title }}"
                                     onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2670&auto=format&fit=crop'">
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2670&auto=format&fit=crop" alt="Hero">
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- Elegant wave divider on left edge --}}
                <div class="aurora-wave"></div>
            </div>
        </section>

        {{-- NEW ENHANCED INFOGRAPHICS STATS BAR --}}
        <div class="aurora-stats-bar-wrapper">
            <div class="container">
                <div class="aurora-stats-grid">
                    <div class="aurora-stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-info">
                            <h3 class="stat-value">1,250</h3>
                            <p class="stat-label">Mahasiswa Aktif</p>
                        </div>
                    </div>
                    <div class="aurora-stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="stat-info">
                            <h3 class="stat-value">145</h3>
                            <p class="stat-label">Dosen Ahli</p>
                        </div>
                    </div>
                    <div class="aurora-stat-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-info">
                            <h3 class="stat-value">8,400</h3>
                            <p class="stat-label">Alumni Tersebar</p>
                        </div>
                    </div>
                    <div class="aurora-stat-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-icon"><i class="fas fa-microscope"></i></div>
                        <div class="stat-info">
                            <h3 class="stat-value">320+</h3>
                            <p class="stat-label">Penelitian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($isPremium)
        <section class="hero-section luxury-theme-hero py-0">
            <div class="container-fluid px-0 h-100">
                <div class="row g-0 align-items-stretch" style="min-height: 85vh;">
                    <div class="col-lg-6 d-flex align-items-center bg-white order-2 order-lg-1">
                        <div class="ps-lg-5 pe-lg-4 py-5 w-100">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xl-10 mx-auto">
                                        <div class="lux-hero-content" data-aos="fade-right">
                                            <span class="lux-hero-tagline">{{ \App\Models\Setting::get('site_abbreviation', 'PREMIUM EDUCATION') }}</span>
                                            <h1 class="lux-hero-title mb-4">{{ \App\Models\Setting::get('site_name', 'Oxford Excellence') }}</h1>
                                            <p class="lux-hero-desc mb-5">{{ \App\Models\Setting::get('site_tagline', 'Developing the leaders of tomorrow through world-class academic programs and professional excellence.') }}</p>
                                            
                                            <div class="d-flex flex-wrap gap-3">
                                                <a href="{{ route('about') }}" class="btn btn-premium">
                                                    {{ __('Explore Programmes') }}
                                                </a>
                                                <a href="{{ route('contact.index') }}" class="btn btn-outline-dark rounded-0 px-4 py-3 fw-bold text-uppercase" style="letter-spacing: 1px;">
                                                    {{ __('Get In Touch') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="swiper lux-hero-swiper h-100 w-100 position-relative">
                            <div class="swiper-wrapper h-100">
                                @forelse($sliders as $slider)
                                    <div class="swiper-slide h-100">
                                        <img src="{{ asset('storage/'.$slider->image) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $slider->title }}">
                                    </div>
                                @empty
                                    <div class="swiper-slide h-100">
                                        <img src="https://images.unsplash.com/photo-1523050853063-bd8012fbb230?auto=format&fit=crop&q=80&w=2670" class="img-fluid w-100 h-100 object-fit-cover" alt="Hero">
                                    </div>
                                @endforelse
                            </div>
                            <div class="lux-hero-gold-accent"></div>
                            {{-- Slider Navigation inside image --}}
                            @if($sliders->count() > 1)
                                <div class="lux-slider-controls">
                                    <div class="lux-swiper-prev"><i class="fas fa-chevron-left"></i></div>
                                    <div class="lux-swiper-next"><i class="fas fa-chevron-right"></i></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Bar nested for Oxford Luxury --}}
            <div class="stats-bar-luxury-wrap">
                <div class="container">
                    <div class="stats-bar-luxury shadow-lg">
                        <div class="row text-center py-4 justify-content-center">
                            @php $cols = count($stats) > 4 ? 3 : (12 / max(count($stats), 1)); @endphp
                            @foreach($stats as $index => $stat)
                                <div class="col-6 col-md-{{ $cols }} stat-item-lux" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                                    <div class="stat-number fw-bold counter-value" data-target="{{ $stat['value'] ?? 0 }}">0</div>
                                    <div class="stat-label">{{ $stat['label'] ?? '-' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="hero-section">
            @if($sliders->count() > 0)
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                    <div class="swiper-slide hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('{{ asset('storage/'.$slider->image) }}')">
                        @if($siteTheme == 'midnight-gold-balakutak' || $siteTheme == 'midnight-landscape-balakutak' || $siteTheme == 'stanford-grow-brown-balakutak' || $siteTheme == 'stanford-grow-navy-balakutak' || $siteTheme == 'stanford-grow-green-balakutak' || $siteTheme == 'stanford-grow-red-balakutak' || $siteTheme == 'stanford-grow-goldenorange-balakutak' || $siteTheme == 'stanford-grow-blacksilver-balakutak')
                            <div class="midnight-hero-globe-overlay"></div>
                            <div class="midnight-hero-grid-overlay"></div>
                        @endif
                        <div class="container h-100 d-flex align-items-center">
                            <div class="hero-content text-white" data-aos="fade-up">
                                <h1 class="hero-title">{{ $slider->title }}</h1>
                                @if($slider->subtitle)
                                    <p class="hero-subtitle">{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->button_text)
                                    <a href="{{ $slider->button_url ?? '#' }}" class="btn btn-primary btn-lg rounded-pill px-5 mt-3">
                                        {{ $slider->button_text }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            @else
            {{-- Default hero if no sliders --}}
            <div class="default-hero position-relative overflow-hidden d-flex align-items-center">
                <div class="page-header-pattern"></div>
                <div class="container py-5 position-relative z-1 text-center" data-aos="zoom-out">
                    {{-- Hero Logo --}}
                    @php 
                        $logoWhite = \App\Models\Setting::get('site_logo_white');
                        $logoMain = \App\Models\Setting::get('site_logo');
                        $displayLogo = (!$logoWhite || $logoWhite == 'images/logo_white.png') ? $logoMain : $logoWhite;
                    @endphp
                    @if($displayLogo)
                        <div class="mb-4" data-aos="fade-down">
                            <img src="{{ asset('storage/'.$displayLogo) }}" height="100" alt="Logo" class="hero-logo-premium">
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            @php $siteAbbr = \App\Models\Setting::get('site_abbreviation', 'PRODI'); @endphp
                            <span class="badge-theme-pill mb-4 d-inline-block px-4 py-2 uppercase tracking-widest" data-aos="fade-down" data-aos-delay="200">{{ $siteAbbr }}</span>
                            
                            <h1 class="hero-title display-3 fw-bold text-white mb-4 notranslate" translate="no" data-aos="fade-up" data-aos-delay="300">
                                {{ \App\Models\Setting::get('site_name', __('menu.home_fallback_title')) }}
                            </h1>
                            
                            <div class="hero-divider-premium mx-auto mb-4" data-aos="stretch-width" data-aos-delay="400"></div>

                            <p class="hero-subtitle lead text-white-50 mb-5 px-lg-5 notranslate" translate="no" data-aos="fade-up" data-aos-delay="500">
                                {{ Str::limit(\App\Models\Setting::get('site_tagline', __('Unggul, Inovatif, dan Berdaya Saing Global')), 250) }}
                            </p>
                            
                            <div class="d-flex flex-wrap justify-content-center gap-3" data-aos="fade-up" data-aos-delay="600">
                                <a href="{{ route('about') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                                    {{ __('Selengkapnya') }} <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                                <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-lg rounded-pill px-5">
                                    {{ __('Hubungi Kami') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Decorative Blobs for depth --}}
                <div class="hero-blob hero-blob-1"></div>
                <div class="hero-blob hero-blob-2"></div>
                <div class="hero-blob hero-blob-3"></div>

                {{-- Floating Icon Decorations --}}
                <div class="floating-icon icon-1"><i class="fas fa-graduation-cap"></i></div>
                <div class="floating-icon icon-2"><i class="fas fa-microscope"></i></div>
                <div class="floating-icon icon-3"><i class="fas fa-globe"></i></div>
            </div>
            @endif

            {{-- Stats Bar --}}
            <div class="stats-bar">
                <!-- Decorative Elements -->
                <div class="stats-bar-decorative">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid-stats" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid-stats)" />
                    </svg>
                </div>
                <div class="stats-bar-blob stats-bar-blob-1"></div>
                <div class="stats-bar-blob stats-bar-blob-2"></div>

                <div class="container">
                    <div class="row text-white text-center py-4 justify-content-center">
                        @php $cols = count($stats) > 4 ? 3 : (12 / max(count($stats), 1)); @endphp
                        @foreach($stats as $index => $stat)
                            <div class="col-6 col-md-{{ $cols }} stat-item mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                                <div class="stat-number fw-bold counter-value" data-target="{{ $stat['value'] ?? 0 }}">0</div>
                                <div class="stat-label">{{ $stat['label'] ?? '-' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif



    {{-- GREETING + VIDEO (Aurora Premium Mod) --}}
    <section class="aurora-greeting-section py-5" style="background: #fff; position:relative; overflow:hidden;">
        <div class="container py-lg-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="aurora-greeting-content">
                        <span class="aurora-tagline mb-2">
                            <i class="fas fa-graduation-cap me-2"></i>{{ __('menu.leader_greeting') }}
                        </span>
                        <h2 class="aurora-greet-title mb-4">
                            {{ \App\Models\Setting::get('greeting_name', __('menu.leader_fallback_name')) }}
                        </h2>
                        
                        <div class="aurora-quote-box mb-4">
                            <i class="fas fa-quote-left aurora-quote-icon"></i>
                            <div class="aurora-quote-text lh-lg" style="text-align:justify;">
                                {!! \Illuminate\Support\Str::words(strip_tags(\App\Models\Setting::get('greeting_text', __('menu.leader_fallback_text'))), 100, '...') !!}
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('about') }}" class="aurora-btn-link">
                                {{ __('menu.read_more') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="aurora-video-container">
                        <div class="aurora-video-glow"></div>
                        @php
                            $rawVideo = \App\Models\Setting::get('profile_video_url', '');
                            $videoUrl = '';
                            if ($rawVideo) {
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $rawVideo, $m)) {
                                    $videoUrl = 'https://www.youtube.com/embed/' . $m[1];
                                } elseif (str_contains($rawVideo, 'youtube.com/embed/')) {
                                    $videoUrl = $rawVideo;
                                }
                            }
                        @endphp
                        @if($videoUrl)
                        <div class="ratio ratio-16x9 aurora-video-frame">
                            <iframe src="{{ $videoUrl }}" title="Video Profil Prodi" allowfullscreen frameborder="0"></iframe>
                        </div>
                        @else
                        <div class="about-card p-5 d-flex flex-column align-items-center justify-content-center text-center" style="min-height:350px; background: #f8fbff; border-radius: 40px; border: 1px dashed #cbd5e1;">
                            <div class="icon-play-aurora mb-3">
                                <i class="fas fa-play fa-xl text-white"></i>
                            </div>
                            <p class="text-muted fw-bold mb-0">Video Profil Segera Hadir</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LATEST NEWS --}}
    <section class="section-news py-5">
        <div class="container">
            <div class="row align-items-end mb-5" data-aos="fade-up">
                <div class="col-lg-8">
                    @if($isPremium)
                        <div class="lux-section-header">
                            <span class="lux-section-tagline">UPDATE TERKINI</span>
                            <h2 class="lux-section-title">Berita & Informasi <span>Kampus Terkini</span></h2>
                            <p class="lux-section-desc">Pantau terus perkembangan terbaru, pengumuman, dan berita seputar lingkungan akademik kami yang terus berkembang.</p>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="header-accent-line bg-theme-accent"></div>
                            <span class="text-uppercase tracking-widest small fw-bold text-muted" style="letter-spacing: 3px;">UPDATE TERKINI</span>
                        </div>
                        <h2 class="display-5 fw-bold text-dark mb-0">Berita & Informasi</h2>
                        <h2 class="display-5 fw-bold text-theme-accent mt-n2">Kampus Terkini</h2>
                        <p class="text-muted mt-3 mb-0">Pantau terus perkembangan terbaru, pengumuman, dan berita seputar lingkungan {{ config('app.name') }}.</p>
                    @endif
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('posts.index') }}" class="btn @if($isPremium) btn-premium @else btn-white shadow-sm rounded-4 @endif px-5 py-3 d-inline-flex align-items-center gap-3">
                        <span>Lihat Semua Berita</span>
                        <i class="fas fa-arrow-right small"></i>
                    </a>
                </div>
            </div>

            @if(str_contains($siteTheme, 'oxford-luxury'))
                <div class="row g-4">
                    @forelse($latestNews->take(4) as $index => $news)
                        @if($index === 0)
                            {{-- Featured Full Width News --}}
                            <div class="col-12 mb-4" data-aos="fade-up">
                                <div class="card border-0 lux-news-card-featured shadow-sm overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-7">
                                            <div class="lux-news-img-wrap h-100">
                                                <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="img-fluid w-100 h-100 object-fit-cover" style="min-height: 400px;">
                                                @if($news->category)
                                                    <div class="lux-news-category">{{ $news->category->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-5 d-flex align-items-center">
                                            <div class="card-body p-lg-5 p-4">
                                                <div class="lux-news-date mb-3 text-uppercase tracking-widest fw-bold" style="font-size: 0.7rem;">
                                                    <i class="far fa-calendar-alt me-2 text-theme-accent"></i> {{ $news->published_at?->format('d M Y') }}
                                                </div>
                                                <h2 class="lux-news-title-lg mb-4">
                                                    <a href="{{ route('posts.show', $news->slug) }}" class="text-decoration-none text-dark">
                                                        {{ $news->title }}
                                                    </a>
                                                </h2>
                                                <p class="lux-news-excerpt mb-5 text-muted lead" style="font-size: 1.05rem;">
                                                    {{ Str::limit(strip_tags($news->content), 200) }}
                                                </p>
                                                <a href="{{ route('posts.show', $news->slug) }}" class="lux-read-more">
                                                    Explore Article <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Subsequent 3 News Items --}}
                            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                <div class="card h-100 border-0 lux-news-card shadow-sm">
                                    <div class="lux-news-img-wrap position-relative">
                                        <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="card-img-top object-fit-cover" style="height: 250px;">
                                        @if($news->category)
                                            <div class="lux-news-category">{{ $news->category->name }}</div>
                                        @endif
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="lux-news-date mb-2">
                                            <i class="far fa-calendar-alt me-2"></i> {{ $news->published_at?->format('d M Y') }}
                                        </div>
                                        <h3 class="lux-news-title mb-3">
                                            <a href="{{ route('posts.show', $news->slug) }}" class="text-decoration-none text-dark stretched-link">
                                                {{ Str::limit($news->title, 80) }}
                                            </a>
                                        </h3>
                                        <p class="lux-news-excerpt text-muted small mb-0">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 px-4 pb-4">
                                        <span class="lux-read-more">Learn More <i class="fas fa-arrow-right ms-1"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-12 text-center text-muted py-5">
                            <i class="fas fa-newspaper fa-4x mb-3 opacity-25"></i>
                            <p>{{ __('menu.no_news') }}</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="row g-4">
                    @forelse($latestNews as $i => $news)
                    @php
                        $colClass = 'col-lg-4';
                        if ($i === 0) $colClass = 'col-lg-8';
                        elseif ($i === 1) $colClass = 'col-lg-4';
                    @endphp
                    <div class="{{ $colClass }} col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="news-immersive-card h-100 rounded-5 overflow-hidden position-relative transition-all duration-700 shadow-lg">
                            <!-- Immersive Image -->
                            <div class="news-bg-image-box h-100 w-100">
                                 <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="img-fluid w-100 h-100 object-fit-cover transition-all duration-700 immersion-img">
                            </div>
    
                            <!-- Gradient Overlay -->
                            <div class="news-immersion-grad"></div>
    
                            <!-- Content Overlay -->
                            <div class="news-immersion-content p-4 d-flex flex-column justify-content-end h-100 w-100 position-absolute top-0 start-0">
                                    <div class="news-meta-row d-flex align-items-center gap-3 mb-3 text-white small">
                                        @if($news->category)
                                            <a href="{{ route('posts.index', ['category' => $news->category->slug]) }}" class="badge-theme-pill text-uppercase fw-bold text-decoration-none transition-all hover-scale position-relative" style="z-index: 10;">
                                                {{ $news->category->name }}
                                            </a>
                                        @endif
                                        <div class="d-flex align-items-center gap-2 opacity-75">
                                            <i class="far fa-calendar-alt"></i>
                                            <span>{{ $news->published_at?->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                
                                <h3 class="news-immersive-title text-white fw-bold {{ ($i === 0) ? 'display-6' : 'h4' }} mb-4">
                                    <a href="{{ route('posts.show', $news->slug) }}" class="text-white text-decoration-none stretched-link transition-all">
                                        {{ Str::limit($news->title, ($i === 0) ? 100 : 70) }}
                                    </a>
                                </h3>
    
                                <div class="news-immersive-footer d-flex align-items-center gap-2">
                                    <span class="text-white text-uppercase small fw-bold tracking-widest letter-spacing-2">SELENGKAPNYA</span>
                                    <div class="news-footer-arrow rounded-circle border border-white border-opacity-50 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-chevron-right small"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fas fa-newspaper fa-4x mb-3 opacity-25"></i>
                        <p>{{ __('menu.no_news') }}</p>
                    </div>
                    @endforelse
                </div>
            @endif
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    @if($upcomingEvents->count() > 0)
    <section class="section-events py-5">
        <div class="container">
            @if($isPremium)
                <div class="row align-items-end mb-5" data-aos="fade-up">
                    <div class="col-lg-8">
                        <div class="lux-section-header mb-0">
                            <span class="lux-section-tagline">{{ __('menu.agenda') }}</span>
                            <h2 class="lux-section-title">{{ __('menu.events_and_activities') }} <span>Agenda Kampus</span></h2>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <a href="{{ route('events.index') }}" class="btn btn-premium px-5 py-3 d-inline-flex align-items-center gap-3">
                            <span>{{ __('menu.see_all_agenda') }}</span>
                            <i class="fas fa-calendar-alt small"></i>
                        </a>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($upcomingEvents as $event)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="lux-event-card h-100 bg-white border @if($loop->first) border-theme-accent @else border-light @endif p-4 position-relative overflow-hidden transition-all hover-lift">
                            <div class="lux-event-date mb-3">
                                <span class="d-block fw-bold text-navy display-6 lh-1">{{ $event->start_date->format('d') }}</span>
                                <span class="d-block text-uppercase tracking-widest small fw-bold text-theme-accent">{{ $event->start_date->isoFormat('MMMM YYYY') }}</span>
                            </div>
                            <h5 class="lux-event-title fw-bold mb-3">
                                <a href="{{ route('events.show', $event->slug) }}" class="text-navy text-decoration-none stretched-link">{{ $event->title }}</a>
                            </h5>
                            @if($event->location)
                                <div class="lux-event-meta d-flex align-items-center gap-2 text-muted small mt-auto">
                                    <i class="fas fa-map-marker-alt text-theme-accent"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
                    <div>
                        <div class="section-badge text-primary fw-semibold mb-1"><i class="fas fa-calendar-alt me-2"></i>{{ __('menu.agenda') }}</div>
                        <h2 class="fw-bold mb-0">{{ __('menu.events_and_activities') }}</h2>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-primary rounded-pill">{{ __('menu.see_all_agenda') }}</a>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($upcomingEvents as $event)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="card event-card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                            <div class="event-date-banner bg-primary text-white text-center py-3">
                                <div class="fw-bold" style="font-size:2rem">{{ $event->start_date->format('d') }}</div>
                                <div class="text-uppercase" style="font-size:.8rem">{{ $event->start_date->isoFormat('MMMM YYYY') }}</div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold">
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-dark text-decoration-none stretched-link">{{ $event->title }}</a>
                                </h6>
                                @if($event->location)
                                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $event->location }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif


    {{-- TESTIMONIALS --}}
    @if($testimonials->count() > 0)
    <section class="section-testimonials py-5">
        <div class="container">
            @if($isPremium)
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="lux-section-header text-center p-0 mb-4" style="border:none">
                        <span class="lux-section-tagline">{{ __('menu.testimonial') }}</span>
                        <h2 class="lux-section-title">{{ __('menu.alumni_says') }} <span>Testimoni Civitas</span></h2>
                    </div>
                </div>
                <div class="swiper testimonial-swiper" data-aos="fade-up">
                    <div class="swiper-wrapper pb-5">
                        @foreach($testimonials as $testimonial)
                        <div class="swiper-slide h-auto">
                            <div class="lux-testimonial-card bg-white p-5 text-center transition-all h-100 border border-light d-flex flex-column">
                                <div class="lux-quote-icon mb-2">
                                    <i class="fas fa-quote-left text-theme-accent opacity-50" style="font-size: 2rem;"></i>
                                </div>
                                <div class="mb-3 text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $testimonial->rating ? '' : 'text-muted opacity-25' }}" style="font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important; font-weight: 900 !important; color: {{ $i <= $testimonial->rating ? '#ffc107' : 'inherit' }};"></i>
                                    @endfor
                                </div>
                                <p class="lux-testimonial-text mb-4 italic text-navy" style="font-size: 1.1rem; line-height: 1.8; font-family: 'Crimson Pro', serif; font-style: italic;">
                                    "{{ $testimonial->content }}"
                                </p>
                                <div class="lux-testimonial-author mt-auto">
                                    <div class="lux-author-img-wrap mb-3 mx-auto">
                                        @if($testimonial->photo)
                                            <img src="{{ asset('storage/'.$testimonial->photo) }}" class="rounded-circle border border-theme-accent p-1" style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto border border-theme-accent" style="width: 70px; height: 70px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold text-navy mb-1">{{ $testimonial->name }}</h6>
                                    <small class="text-theme-accent text-uppercase tracking-widest fw-bold" style="font-size: 0.7rem;">{{ $testimonial->position }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="section-badge text-primary fw-semibold mb-2"><i class="fas fa-comments me-2"></i>{{ __('menu.testimonial') }}</div>
                    <h2 class="fw-bold"><i class="fas fa-user-graduate me-2 text-primary"></i>{{ __('menu.alumni_says') }}</h2>
                </div>
                <div class="swiper testimonial-swiper" data-aos="fade-up">
                    <div class="swiper-wrapper pb-5">
                        @foreach($testimonials as $testimonial)
                        <div class="swiper-slide h-auto">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mx-2 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    @if($testimonial->photo)
                                        <img src="{{ asset('storage/'.$testimonial->photo) }}" class="rounded-circle me-3" style="width: 55px; height: 55px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 55px; height: 55px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $testimonial->name }}</h6>
                                        <small class="text-muted d-block">{{ $testimonial->position }}</small>
                                        <div class="mt-1 text-warning" style="font-size: 0.85rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $testimonial->rating ? '' : 'text-muted opacity-25' }}" style="font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important; font-weight: 900 !important; color: {{ $i <= $testimonial->rating ? '#ffc107' : 'inherit' }};"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted italic small"><i class="fas fa-quote-left me-2 text-primary opacity-50"></i>{{ $testimonial->content }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- PARTNERS MARQUEE --}}
    @if($partners->count() > 0)
    <section class="section-partners py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="text-center mb-4">
                <div class="section-badge text-primary fw-semibold mb-1 justify-content-center"><i class="fas fa-handshake me-2"></i>Mitra & Kerjasama</div>
                <h5 class="fw-bold text-dark mb-0">Institusi Mitra Kami</h5>
            </div>
        </div>
        @if($partners->count() <= 6)
        {{-- Centered layout for few partners --}}
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 py-3">
                @foreach($partners as $partner)
                <div class="partners-marquee-item">
                    @if($partner->website_url)
                        <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                    @endif
                    @if($partner->logo)
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" loading="lazy">
                    @else
                        <span class="partner-name-text">{{ $partner->name }}</span>
                    @endif
                    @if($partner->website_url)
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @else
        {{-- Marquee for many partners --}}
        <div class="partners-marquee-wrapper">
            <div class="partners-marquee-track">
                @foreach($partners as $partner)
                    <div class="partners-marquee-item">
                        @if($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                        @endif
                        @if($partner->logo)
                            <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" loading="lazy">
                        @else
                            <span class="partner-name-text">{{ $partner->name }}</span>
                        @endif
                        @if($partner->website_url)
                            </a>
                        @endif
                    </div>
                @endforeach
                {{-- Duplicate for seamless loop --}}
                @foreach($partners as $partner)
                    <div class="partners-marquee-item">
                        @if($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                        @endif
                        @if($partner->logo)
                            <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" loading="lazy">
                        @else
                            <span class="partner-name-text">{{ $partner->name }}</span>
                        @endif
                        @if($partner->website_url)
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>
    @endif

    {{-- AURORA CTA SECTION (Elite Mod) --}}
    <section class="aurora-cta-section py-5 text-white position-relative overflow-hidden">
        <div class="aurora-cta-bg-glow"></div>
        <div class="aurora-cta-pattern"></div>
        <div class="aurora-cta-blob blob-1"></div>
        <div class="aurora-cta-blob blob-2"></div>
        
        <div class="container text-center position-relative z-10 py-5" data-aos="zoom-in">
            <h2 class="aurora-cta-title mb-3">{{ __('menu.cta_title') }}</h2>
            <p class="aurora-cta-subtitle mb-5 lead opacity-85 mx-auto" style="max-width: 700px;">{{ __('menu.cta_subtitle') }}</p>
            
            <div class="d-flex gap-4 justify-content-center flex-wrap">
                <a href="{{ route('contact.index') }}" class="aurora-btn-premium">
                    <i class="fas fa-info-circle me-2"></i>{{ __('menu.registration_info') }}
                </a>
                <a href="{{ route('academic') }}" class="aurora-btn-outline">
                    <i class="fas fa-book me-2"></i>{{ __('menu.see_curriculum') }}
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
// Hero Swiper (Standard)
if (document.querySelector('.hero-swiper')) {
    new Swiper('.hero-swiper', {
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
        navigation: { nextEl: '.hero-swiper .swiper-button-next', prevEl: '.hero-swiper .swiper-button-prev' },
        effect: 'fade',
        fadeEffect: { crossFade: true }
    });
}

// Aurora Hero — Synced Dual Swiper
const auroraHero = document.querySelector('.aurora-hero');
if (auroraHero) {
    const totalAuroraSlides = auroraHero.querySelectorAll('.aurora-hero-right .swiper-slide').length;
    const auroraLoop = totalAuroraSlides > 1;

    // 1. Text Swiper
    const auroraTextSwiper = new Swiper('.aurora-text-swiper', {
        loop: auroraLoop,
        speed: 800,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        allowTouchMove: false
    });

    // 2. Image Swiper
    const auroraImgSwiper = new Swiper('.aurora-hero-right .aurora-swiper', {
        loop: auroraLoop,
        speed: 900,
        autoplay: auroraLoop ? { delay: 5000, disableOnInteraction: false } : false,
        effect: auroraLoop ? 'fade' : 'slide',
        fadeEffect: { crossFade: true },
        on: {
            slideChange: function() {
                // Update dots
                const dots = document.querySelectorAll('.aurora-dot');
                dots.forEach((d, i) => d.classList.toggle('active', i === this.realIndex));
            }
        }
    });

    // Link them
    auroraImgSwiper.controller.control = auroraTextSwiper;
    auroraTextSwiper.controller.control = auroraImgSwiper;

    // Dot click
    document.querySelectorAll('.aurora-dot').forEach((dot, i) => {
        dot.addEventListener('click', () => {
            auroraImgSwiper.slideToLoop(i);
        });
    });
}

// Luxury Split Slider Swiper
if (document.querySelector('.lux-hero-swiper')) {
    new Swiper('.lux-hero-swiper', {
        loop: true,
        speed: 1200,
        parallax: true,
        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },
        navigation: { 
            nextEl: '.lux-swiper-next', 
            prevEl: '.lux-swiper-prev' 
        },
        effect: 'slide'
    });
}

// Testimonial Swiper
new Swiper('.testimonial-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: { delay: 4000 },
    pagination: { el: '.testimonial-swiper .swiper-pagination', clickable: true },
    breakpoints: {
        576: { slidesPerView: 2 },
        992: { slidesPerView: 3 }
    }
});

// Counter Animation for Infographics
const counters = document.querySelectorAll('.counter-value');
const speed = 200;

const runCounter = () => {
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        updateCount();
    });
};

// Intersection Observer for Counter
const observerOptions = { threshold: 0.2 };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            runCounter();
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

const infoSection = document.querySelector('.stats-bar');
if (infoSection) {
    observer.observe(infoSection);
}

// Partner Swiper
new Swiper('.partner-swiper', {
    slidesPerView: 3,
    spaceBetween: 30,
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false },
    breakpoints: {
        576: { slidesPerView: 4 },
        992: { slidesPerView: 6 }
    }
});
</script>
@endpush
