<div class="top-menu-wrapper">
    <div class="container d-flex justify-content-between align-items-center py-2" style="font-size: 0.85rem; font-weight: 500;">
        {{-- Left Side: Top Menu Items --}}
        <div class="top-menu-items d-none d-md-flex">
            @if(isset($sharedMenus['top-menu']) && $sharedMenus['top-menu']->items->count() > 0)
                @foreach($sharedMenus['top-menu']->items as $item)
                    <a href="{{ $item->resolved_url }}" 
                       class="top-menu-link me-4 {{ $item->css_class }}" 
                       target="{{ $item->target }}">
                        @if($item->icon) <i class="{{ $item->icon }} top-menu-icon"></i> @endif
                        <span>{{ $item->label }}</span>
                    </a>
                @endforeach
            @endif
        </div>

        {{-- Right Side: Utilities (Lang, Theme, Auth) --}}
        <div class="d-flex align-items-center gap-3 top-utilities ms-auto">
            {{-- Language Switcher (Google Translate Custom UI) --}}
            <div class="dropdown">
                <button class="btn btn-sm top-btn rounded-pill px-3 d-flex align-items-center" type="button" id="langDropTop" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-globe me-2"></i> <span id="currentLangLabel">ID</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 animate slideIn" aria-labelledby="langDropTop">
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0)" onclick="changeGTranslate('id')">
                            <span class="fw-bold me-2" style="width: 25px;">ID</span>
                            <span class="text-muted small">Indonesia</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0)" onclick="changeGTranslate('en')">
                            <span class="fw-bold me-2" style="width: 25px;">EN</span>
                            <span class="text-muted small">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0)" onclick="changeGTranslate('ar')">
                            <span class="fw-bold me-2" style="width: 25px;">AR</span>
                            <span class="text-muted small">Arabic</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            {{-- Theme Toggle --}}
            <button x-data="themeToggle" @click="toggle()" class="btn btn-sm top-btn-utility rounded-circle d-flex align-items-center justify-content-center" title="{{ __('menu.theme') }}">
                <i x-show="!dark" class="fas fa-moon"></i>
                <i x-show="dark" class="fas fa-sun"></i>
            </button>

            {{-- Fullscreen Toggle --}}
            <button id="fullscreenToggle" class="btn btn-sm top-btn-utility rounded-circle d-flex align-items-center justify-content-center" title="Fullscreen">
                <i class="fas fa-expand" id="fsIcon"></i>
            </button>

            {{-- Auth Buttons --}}
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-exclusive rounded-pill px-3 d-none d-sm-inline-flex align-items-center">
                    <i class="fas fa-user-shield me-2"></i> {{ __('menu.dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm top-btn rounded-pill px-3 d-flex align-items-center">
                    <i class="fas fa-lock me-2"></i> {{ __('menu.login') }}
                </a>
            @endauth
        </div>
    </div>
</div>

<style>
    /* Google translate overrides */
    #google_translate_element select {
        background-color: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50rem;
        padding: 4px 12px;
        font-size: 0.875rem;
        outline: none;
        cursor: pointer;
    }
    #google_translate_element select:hover {
        background-color: rgba(100, 255, 218, 0.1);
        color: #64ffda;
        border-color: rgba(100, 255, 218, 0.3);
    }
    .goog-te-gadget {
        color: transparent !important;
        font-size: 0;
    }
    .goog-te-gadget .goog-te-combo {
        margin: 0;
    }
    .goog-logo-link {
        display: none !important;
    }
    .goog-te-banner-frame {
        display: none !important;
    }
    body {
        top: 0 !important;
    }
    #goog-gt-tt, .goog-te-balloon-frame {
        display: none !important;
    }
    .goog-text-highlight {
        background: none !important;
        box-shadow: none !important;
    }
    iframe.skiptranslate {
        display: none !important;
    }

    .top-menu-wrapper {
        background: linear-gradient(135deg, #0a192f 0%, #112240 50%, #0a192f 100%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4), inset 0 -1px 0 rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        position: relative;
        z-index: 1100 !important; /* Higher than main navbar z-index */
        padding: 5px 0; 
        overflow: visible;
    }

    .top-menu-wrapper::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(100, 255, 218, 0.15) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(0, 180, 216, 0.15) 0%, transparent 40%);
        pointer-events: none;
        z-index: 0;
    }

    .top-menu-wrapper::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to top, rgba(100, 255, 218, 0.1) 0%, transparent 100%);
        clip-path: polygon(
            0% 100%, 5% 70%, 10% 90%, 15% 50%, 20% 80%, 25% 20%, 30% 60%, 35% 85%, 
            40% 30%, 45% 70%, 50% 10%, 55% 90%, 60% 40%, 65% 80%, 70% 20%, 75% 60%, 
            80% 10%, 85% 70%, 90% 90%, 95% 50%, 100% 100%
        );
        filter: blur(5px);
        opacity: 0.6;
        pointer-events: none;
        z-index: 0;
    }

    .top-menu-wrapper > .container {
        position: relative;
        z-index: 1;
    }
    
    .top-menu-items {
        display: flex;
        align-items: center;
    }

    .top-menu-link {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        letter-spacing: 0.8px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: inline-flex;
        align-items: center;
        position: relative;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 0.95rem; 
    }

    .top-menu-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 3px; 
        bottom: -8px;
        left: 0;
        background: linear-gradient(90deg, #64ffda, #00b4d8);
        transition: width 0.3s ease;
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(100, 255, 218, 0.6);
    }

    .top-menu-link:hover {
        color: #ffffff;
        text-shadow: 0 0 12px rgba(255, 255, 255, 0.4);
    }
    
    .top-menu-link:hover::after {
        width: 100%;
    }

    .top-menu-icon {
        color: #00b4d8; 
        margin-right: 8px;
        font-size: 1.2rem; 
        transition: all 0.3s ease;
        filter: drop-shadow(0 0 5px rgba(0, 180, 216, 0.5));
    }
    
    .top-menu-link:hover .top-menu-icon {
        transform: scale(1.15) translateY(-2px);
        color: #64ffda; 
        filter: drop-shadow(0 0 8px rgba(100, 255, 218, 0.8));
    }
    
    /* Utility Buttons specific to Top Menu */
    .top-btn {
        background-color: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .top-btn:hover {
        background: var(--gold, #64ffda);
        color: #0a192f !important;
        border-color: var(--gold, #64ffda);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
    }

    .top-btn-utility {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .top-btn-utility:hover {
        background: rgba(100, 255, 218, 0.1);
        color: #64ffda;
        border-color: #64ffda;
        transform: rotate(15deg) scale(1.1);
    }
    
    .btn-exclusive {
        background: linear-gradient(135deg, #64ffda 0%, #00b4d8 100%);
        color: #0a192f;
        border: none;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(100, 255, 218, 0.2);
        transition: all 0.3s ease;
    }
    
    .btn-exclusive:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(100, 255, 218, 0.4);
        color: #0a192f;
    }

    /* Fix for language dropdown being covered */
    .top-menu-wrapper .dropdown-menu {
        z-index: 9999 !important;
    }
</style>

<script>
    function changeGTranslate(lang) {
        if (lang === 'id') {
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + location.hostname + ";";
        } else {
            document.cookie = `googtrans=/id/${lang}; path=/;`;
            document.cookie = `googtrans=/id/${lang}; path=/; domain=${location.hostname};`;
        }
        location.reload();
    }

    document.addEventListener("DOMContentLoaded", function() {
        let match = document.cookie.match(/(^| )googtrans=([^;]+)/);
        let currentLang = 'ID';
        if (match) {
            let parts = match[2].split('/');
            if (parts.length > 2 && parts[2]) {
                currentLang = parts[2].toUpperCase();
            }
        }
        let lbl = document.getElementById('currentLangLabel');
        if(lbl) lbl.innerText = currentLang;

        // Fullscreen Toggle Logic
        const fsToggle = document.getElementById('fullscreenToggle');
        const fsIcon = document.getElementById('fsIcon');

        if (fsToggle) {
            fsToggle.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                        document.documentElement.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) { // Firefox
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) { // Chrome, Safari and Opera
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) { // IE/Edge
                        document.msExitFullscreen();
                    }
                }
            });
        }

        function updateFsIcon() {
            if (document.fullscreenElement) {
                fsIcon.classList.remove('fa-expand');
                fsIcon.classList.add('fa-compress');
            } else {
                fsIcon.classList.remove('fa-compress');
                fsIcon.classList.add('fa-expand');
            }
        }

        document.addEventListener('fullscreenchange', updateFsIcon);
        document.addEventListener('webkitfullscreenchange', updateFsIcon);
        document.addEventListener('mozfullscreenchange', updateFsIcon);
        document.addEventListener('MSFullscreenChange', updateFsIcon);
    });
</script>

<nav class="navbar navbar-expand-lg border-bottom shadow-sm sticky-top elegant-navbar" id="main-navbar">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center gap-3 notranslate" translate="no" href="{{ route('home') }}">
            @php 
                $logo = \App\Models\Setting::get('site_logo');
                $logoWhiteRaw = \App\Models\Setting::get('site_logo_white');
                $logoWhite = !$logoWhiteRaw ? $logo : $logoWhiteRaw;
            @endphp
            @if($logo)
                <div class="logo-container">
                    <img src="{{ asset('storage/'.$logo) }}" height="68" alt="Logo" class="notranslate site-logo-main" translate="no">
                    @if($logoWhite)
                        <img src="{{ asset('storage/'.$logoWhite) }}" height="68" alt="Logo" class="notranslate site-logo-white" translate="no" style="display: none;">
                    @endif
                </div>
            @else
                <div class="brand-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:68px;height:68px;font-size:1.8rem">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            @endif
            <div class="notranslate" translate="no">
                <div class="fw-bold elegant-brand-title" style="font-size:1.25rem;line-height:1.2; letter-spacing: -0.3px;">
                    @php
                        $layout = \App\Models\Setting::get('site_name_layout', '1');
                        if ($layout == '2') {
                            $line1 = \App\Models\Setting::get('site_name_line1', '');
                            $line2 = \App\Models\Setting::get('site_name_line2', '');
                            $siteNameDisplay = e($line1) . '<br>' . e($line2);
                        } else {
                            $siteName = \App\Models\Setting::get('site_name', 'Website Prodi');
                            $escapedName = e($siteName);
                            $siteNameDisplay = str_contains($escapedName, 'Program Studi') 
                                ? str_replace('Program Studi', 'Program Studi<br>', $escapedName) 
                                : $escapedName;
                        }
                    @endphp
                    {!! $siteNameDisplay !!}
                </div>
                <div class="elegant-brand-subtitle mt-1" style="font-size:.85rem;line-height:1; font-weight: 500;">{{ \App\Models\Setting::get('site_sub_name', '') }}</div>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto gap-2 align-items-center">
                @if(isset($sharedMenus['main-menu']) && $sharedMenus['main-menu']->items->count() > 0)
                    @foreach($sharedMenus['main-menu']->items as $item)
                        @if($item->children->count() > 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link main-nav-link dropdown-toggle px-3 {{ request()->url() == $item->resolved_url ? 'active text-primary' : '' }} {{ $item->css_class }}" href="#" id="menuDrop{{ $item->id }}" data-bs-toggle="dropdown">
                                    @if($item->icon) <i class="{{ $item->icon }} main-nav-icon me-1"></i> @endif
                                    {{ $item->label }}
                                </a>
                                <ul class="dropdown-menu shadow-lg border-0 elegant-dropdown" aria-labelledby="menuDrop{{ $item->id }}">
                                    @foreach($item->children as $child)
                                        <li>
                                            <a class="dropdown-item elegant-dropdown-item py-2" href="{{ $child->resolved_url }}" target="{{ $child->target }}">
                                                @if($child->icon) <i class="{{ $child->icon }} me-2 text-primary"></i> @endif
                                                {{ $child->label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link main-nav-link px-3 {{ request()->url() == $item->resolved_url ? 'active text-primary' : '' }} {{ $item->css_class }}" href="{{ $item->resolved_url }}" target="{{ $item->target }}">
                                    @if($item->icon) <i class="{{ $item->icon }} main-nav-icon me-1"></i> @endif
                                    {{ $item->label }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @else
                    {{-- Default Fallback Menu --}}
                    <li class="nav-item"><a class="nav-link main-nav-link px-3 {{ request()->routeIs('home') ? 'active text-primary' : '' }}" href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link main-nav-link px-3 {{ request()->routeIs('posts.*') ? 'active text-primary' : '' }}" href="{{ route('posts.index') }}">{{ __('menu.news') }}</a></li>
                    <li class="nav-item"><a class="nav-link main-nav-link px-3 {{ request()->routeIs('contact.*') ? 'active text-primary' : '' }}" href="{{ route('contact.index') }}">{{ __('menu.contact') }}</a></li>
                @endif
                
                {{-- Search --}}
                <li class="nav-item ms-3 d-flex align-items-center">
                    <button type="button" class="btn btn-primary shadow-sm rounded-circle d-flex align-items-center justify-content-center hover-lift" 
                            style="width:42px;height:42px" title="{{ __('menu.search') }}"
                            data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

@if(isset($sharedMenus['secondary-menu']) && $sharedMenus['secondary-menu']->items->count() > 0)
    <div class="secondary-menu-wrapper py-2">
        <div class="container d-flex justify-content-center align-items-center gap-2 flex-wrap">
            @foreach($sharedMenus['secondary-menu']->items as $item)
                @if($item->children->count() > 0)
                    <div class="dropdown">
                        <a class="secondary-menu-link dropdown-toggle py-1 px-3 text-decoration-none fw-semibold d-inline-flex align-items-center" href="#" id="secDrop{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($item->icon) <i class="{{ $item->icon }} me-1"></i> @endif
                            <span>{{ $item->label }}</span>
                        </a>
                        <ul class="dropdown-menu shadow-lg border-0 elegant-dropdown" aria-labelledby="secDrop{{ $item->id }}">
                            @foreach($item->children as $child)
                                <li>
                                    <a class="dropdown-item elegant-dropdown-item py-2" href="{{ $child->resolved_url }}" target="{{ $child->target }}">
                                        @if($child->icon) <i class="{{ $child->icon }} me-2 text-primary"></i> @endif
                                        {{ $child->label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <a href="{{ $item->resolved_url }}" class="secondary-menu-link py-1 px-3 text-decoration-none fw-semibold d-inline-flex align-items-center" target="{{ $item->target }}">
                        @if($item->icon) <i class="{{ $item->icon }} me-1"></i> @endif
                        <span>{{ $item->label }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endif

{{-- Search Modal --}}
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-body p-5 bg-dark">
                <div class="text-center mb-4">
                    <h3 class="text-white fw-bold mb-2">{{ __('menu.search') }}</h3>
                    <p class="text-white-50 small">{{ __('Cari informasi, berita, atau agenda di Website Prodi') }}</p>
                </div>
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-0 text-primary ps-4">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 py-4 px-3" 
                               placeholder="{{ __('menu.search_placeholder') }}" 
                               style="font-size: 1.1rem; border-radius: 0 15px 15px 0;"
                               required minlength="3" autofocus>
                        <button class="btn btn-primary px-5 fw-bold" type="submit" style="border-radius: 15px; margin-left: 10px;">
                            {{ __('Cari') }}
                        </button>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <small class="text-white-50">{{ __('Tekan Enter untuk memulai pencarian') }}</small>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Secondary Menu Styling */
    .secondary-menu-wrapper {
        background: #f8fafc;
        border-bottom: 1px solid rgba(0, 86, 179, 0.05);
        position: relative;
        z-index: 1040;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.02);
    }
    .secondary-menu-link {
        color: #475569;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
        border-radius: 6px;
    }
    .secondary-menu-link:hover, .secondary-menu-link.show {
        color: #0056b3;
        background-color: rgba(0, 86, 179, 0.05);
    }
    
    @media (max-width: 768px) {
        .secondary-menu-wrapper .container {
            flex-wrap: nowrap !important;
            overflow-x: auto;
            justify-content: start !important;
            padding-bottom: 5px;
            -webkit-overflow-scrolling: touch;
        }
        .secondary-menu-link {
            white-space: nowrap;
        }
    }

    /* Dark Mode for Secondary Menu */
    .dark .secondary-menu-wrapper {
        background: #0d1117;
        border-bottom: 1px solid rgba(100, 255, 218, 0.05);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .dark .secondary-menu-link {
        color: #8b949e;
    }
    .dark .secondary-menu-link:hover, .dark .secondary-menu-link.show {
        color: #64ffda;
        background-color: rgba(100, 255, 218, 0.08);
    }

    /* Elegant Main Menu Styling */
    .elegant-navbar {
        background: linear-gradient(120deg, #ffffff 0%, #f6f9fc 50%, #e9ecef 100%);
        border-bottom: 1px solid rgba(0, 86, 179, 0.1) !important;
        position: relative;
        z-index: 1050 !important; /* Lower than top-menu-wrapper but high enough for content */
        overflow: visible;
    }
    .elegant-navbar::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: 
            radial-gradient(circle at 70% 20%, rgba(0, 86, 179, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 10% 80%, rgba(0, 180, 216, 0.08) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }
    .elegant-navbar::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0; width: 100%; height: 100%;
        background: linear-gradient(to top, rgba(0, 180, 216, 0.05) 0%, transparent 100%);
        clip-path: polygon(
            0% 100%, 8% 60%, 15% 85%, 22% 40%, 30% 75%, 38% 15%, 45% 90%, 52% 35%, 
            60% 80%, 68% 10%, 75% 70%, 83% 45%, 90% 95%, 100% 100%
        );
        filter: blur(4px);
        opacity: 0.6;
        pointer-events: none;
        z-index: 0;
    }
    .elegant-navbar > .container {
        position: relative;
        z-index: 1;
    }

    #main-navbar {
        padding-top: 0.8rem;
        padding-bottom: 0.8rem;
    }

    .navbar-nav {
        position: relative;
        padding-right: 1rem;
    }
    .navbar-nav::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at center, rgba(0, 180, 216, 0.04) 0%, transparent 80%);
        clip-path: polygon(0 100%, 15% 40%, 30% 60%, 45% 20%, 60% 50%, 75% 30%, 100% 100%);
        filter: blur(15px);
        opacity: 0.3;
        pointer-events: none;
        z-index: -1;
    }
    
    .main-nav-link {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: #2b2b2b !important;
        text-transform: capitalize;
        letter-spacing: 0.3px;
        position: relative;
        transition: color 0.3s ease;
    }

    .main-nav-link:hover, .main-nav-link.active {
        color: #0056b3 !important; /* Elegant corporate blue */
    }

    .main-nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background-color: #0056b3;
        transition: width 0.3s ease;
    }

    .main-nav-link:hover::before, .main-nav-link.active::before {
        width: 70%;
    }

    .main-nav-icon {
        color: #0056b3;
        opacity: 0.8;
        font-size: 1.1rem;
    }

    /* Dropdown Styling */
    .elegant-dropdown {
        border-radius: 8px;
        animation: dropFadeUp 0.3s ease forwards;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        margin-top: 10px;
    }

    .elegant-dropdown-item {
        font-weight: 500;
        color: #4a4a4a;
        transition: all 0.2s ease;
        padding: 0.6rem 1.5rem;
    }

    .elegant-dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0056b3;
        padding-left: 1.8rem; /* Subtle indent effect on hover */
    }

    @keyframes dropFadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 86, 179, 0.3) !important;
    }

    /* Elegant Brand Text */
    .elegant-brand-title {
        background: linear-gradient(135deg, #001f54 0%, #034078 50%, #00a6fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.05); /* very subtle */
    }
    .elegant-brand-subtitle {
        color: #555;
        background: linear-gradient(90deg, #333333, #6c757d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Dark Mode Adjustments for High Contrast & Luxury */
    .dark .elegant-navbar {
        background: linear-gradient(120deg, #0b0c10 0%, #1f2833 50%, #0b0c10 100%) !important;
        border-bottom: 2px solid var(--lux-gold, #c5a059) !important;
        box-shadow: 0 4px 20px rgba(197, 160, 89, 0.2) !important;
    }
    
    .dark .elegant-navbar::before {
        background-image: 
            radial-gradient(circle at 20% 30%, rgba(197, 160, 89, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.15) 0%, transparent 50%) !important;
        opacity: 0.9;
    }

    .dark .elegant-navbar::after {
        background: linear-gradient(to top, rgba(197, 160, 89, 0.2) 0%, transparent 100%) !important;
        clip-path: polygon(
            0% 100%, 5% 75%, 12% 90%, 20% 45%, 28% 80%, 35% 20%, 42% 65%, 50% 10%, 
            58% 85%, 65% 30%, 72% 70%, 80% 15%, 88% 55%, 95% 40%, 100% 100%
        ) !important;
        filter: blur(3px) !important;
        opacity: 0.8;
    }
    
    .dark .elegant-brand-title {
        background: linear-gradient(135deg, #e0e7ff 0%, #93c5fd 50%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 15px rgba(147, 197, 253, 0.3);
    }
    
    .dark .elegant-brand-subtitle {
        background: linear-gradient(90deg, #cbd5e1, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Fix for Stanford themes menu overlapping with announcement bar */
    [class*="theme-stanford-grow-"] #main-navbar.elegant-navbar:not(.scrolled) {
        position: relative !important;
        top: 0 !important;
        background: var(--p-dark) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
    .dark [class*="theme-stanford-grow-"] #main-navbar.elegant-navbar:not(.scrolled) {
        background: #2e2d29 !important;
    }
    [class*="theme-stanford-grow-"] .hero-content {
        padding-top: 60px !important;
    }

    /* Softer and smaller typography for Stanford and Oxford themes */
    
    /* Stanford Themes overrides */
    [class*="theme-stanford-grow-"] h1,
    [class*="theme-stanford-grow-"] h2,
    [class*="theme-stanford-grow-"] h3,
    [class*="theme-stanford-grow-"] h4,
    [class*="theme-stanford-grow-"] h5,
    [class*="theme-stanford-grow-"] h6,
    [class*="theme-stanford-grow-"] .elegant-brand-title {
        font-weight: 600 !important;
    }
    [class*="theme-stanford-grow-"] .hero-title {
        font-size: clamp(1.5rem, 3.5vw, 2.2rem) !important;
        font-weight: 600 !important;
    }
    [class*="theme-stanford-grow-"] .hero-subtitle {
        font-size: 0.9rem !important;
        opacity: 0.8 !important;
    }
    [class*="theme-stanford-grow-"] .section-title,
    [class*="theme-stanford-grow-"] .lux-section-header .lux-section-title {
        font-size: clamp(1.5rem, 3vw, 2rem) !important;
        font-weight: 600 !important;
        letter-spacing: -0.5px !important;
    }
    [class*="theme-stanford-grow-"] .display-4 {
        font-size: clamp(1.8rem, 4vw, 2.5rem) !important;
        font-weight: 600 !important;
    }
    [class*="theme-stanford-grow-"] .elegant-brand-title {
        font-size: 1.35rem !important;
    }

    /* Oxford Themes overrides */
    body[class*="theme-oxford-"] h1,
    body[class*="theme-oxford-"] h2,
    body[class*="theme-oxford-"] h3,
    body[class*="theme-oxford-"] h4,
    body[class*="theme-oxford-"] h5,
    body[class*="theme-oxford-"] h6 {
        font-weight: 650 !important;
    }
    body[class*="theme-oxford-"] .elegant-brand-title {
        font-size: 1.15rem !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
    }
    body[class*="theme-oxford-"] .elegant-brand-subtitle {
        font-size: 0.8rem !important;
        font-weight: 400 !important;
        opacity: 0.85 !important;
    }
    body[class*="theme-oxford-"] .main-nav-link {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px !important;
    }
    body[class*="theme-oxford-"] .lux-hero-title {
        font-size: clamp(1.8rem, 4vw, 2.6rem) !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        margin-bottom: 1.5rem !important;
    }
    body[class*="theme-oxford-"] .lux-hero-desc {
        font-size: 1rem !important;
        line-height: 1.6 !important;
        margin-bottom: 2rem !important;
    }
    body[class*="theme-oxford-"] .lux-section-title {
        font-size: clamp(1.5rem, 3vw, 2rem) !important;
        font-weight: 700 !important;
    }
    body[class*="theme-oxford-"] .display-4,
    body[class*="theme-oxford-"] .page-header-premium h1 {
        font-size: clamp(1.6rem, 3.5vw, 2.2rem) !important;
        font-weight: 700 !important;
        letter-spacing: -0.5px !important;
    }
    body[class*="theme-oxford-"] .page-header-premium {
        padding: 5rem 0 !important;
    }
    body[class*="theme-oxford-"] .aurora-cta-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem) !important;
    }

    /* Reset styles for any footer elements inside the main content area (e.g. copied/pasted in article editor) */
    body.frontend-body main footer,
    body.frontend-body main .aurora-footer,
    body.frontend-body .post-body footer,
    body.frontend-body .post-body .aurora-footer,
    body.frontend-body .article-content footer,
    body.frontend-body .article-content .aurora-footer,
    body.frontend-body .page-content footer,
    body.frontend-body .page-content .aurora-footer {
        background: transparent !important;
        background-image: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 2rem 0 0 0 !important;
        color: inherit !important;
        box-shadow: none !important;
        height: auto !important;
        min-height: 0 !important;
        position: static !important;
        overflow: visible !important;
    }
    
    body.frontend-body main footer::before,
    body.frontend-body main footer::after,
    body.frontend-body main .aurora-footer::before,
    body.frontend-body main .aurora-footer::after,
    body.frontend-body .post-body footer::before,
    body.frontend-body .post-body footer::after,
    body.frontend-body .post-body .aurora-footer::before,
    body.frontend-body .post-body .aurora-footer::after,
    body.frontend-body .article-content footer::before,
    body.frontend-body .article-content footer::after,
    body.frontend-body .article-content .aurora-footer::before,
    body.frontend-body .article-content .aurora-footer::after,
    body.frontend-body .page-content footer::before,
    body.frontend-body .page-content footer::after,
    body.frontend-body .page-content .aurora-footer::before,
    body.frontend-body .page-content .aurora-footer::after {
        display: none !important;
        content: none !important;
    }

    body.frontend-body main footer *,
    body.frontend-body main .aurora-footer *,
    body.frontend-body .post-body footer *,
    body.frontend-body .post-body .aurora-footer *,
    body.frontend-body .article-content footer *,
    body.frontend-body .article-content .aurora-footer *,
    body.frontend-body .page-content footer *,
    body.frontend-body .page-content .aurora-footer * {
        background: transparent !important;
        background-image: none !important;
        color: inherit !important;
        border: none !important;
        box-shadow: none !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        padding: 0 !important;
        margin: 0 !important;
        position: static !important;
    }
</style>
