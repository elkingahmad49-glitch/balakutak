<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title class="notranslate" translate="no">@stack('title') {{ \App\Models\Setting::get('site_name', config('app.name')) }}</title>
    <meta name="description" content="@stack('meta_description'){{ \App\Models\Setting::get('seo_meta_description', '') }}">
    <meta name="keywords" content="@stack('meta_keywords'){{ \App\Models\Setting::get('seo_keywords', '') }}">
    <meta name="author" content="{{ \App\Models\Setting::get('site_name', 'Website Prodi') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@stack('og_title'){{ \App\Models\Setting::get('site_name') }}">
    <meta property="og:description" content="@stack('og_description'){{ \App\Models\Setting::get('seo_meta_description') }}">
    <meta property="og:image" content="@stack('og_image'){{ asset('images/og-default.jpg') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">

    {{-- Favicon --}}
    @php $favicon = \App\Models\Setting::get('site_favicon'); @endphp
    @if($favicon)
        <link rel="icon" href="{{ asset('storage/'.$favicon) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    {{-- AOS Animations --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    {{-- Foundation Styles --}}
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}?v={{ time() }}">

    {{-- Theme Overrides --}}
    @php
        $siteTheme = \App\Models\Setting::get('site_theme', 'aurora-glass-balakutak');
        $themeFile = "css/themes/{$siteTheme}.css";
    @endphp
    @if($siteTheme != 'default' && file_exists(public_path($themeFile)))
        <link rel="stylesheet" href="{{ asset($themeFile) }}?v={{ time() }}">
    @endif

    {{-- Unified Typography Override --}}
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}?v={{ time() }}">

    @stack('styles')

    {{-- Google Analytics --}}
    @if($ga = \App\Models\Setting::get('google_analytics'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $ga }}');
    </script>
    @endif
</head>
<body class="frontend-body theme-{{ $siteTheme }}">



    {{-- Navigation --}}
    @include('frontend.partials.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Chatbot Widget --}}
    @include('frontend.partials.chatbot')

    {{-- Accessibility Widget --}}
    @include('frontend.partials.accessibility-widget')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // AOS Init
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });



        // Dark mode toggle (Alpine handles the class, this updates body bg)
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeToggle', () => ({
                dark: localStorage.getItem('darkMode') === 'true',
                toggle() {
                    this.dark = !this.dark;
                    localStorage.setItem('darkMode', this.dark);
                    document.documentElement.classList.toggle('dark', this.dark);
                }
            }));
        });
    </script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id', 
                includedLanguages: 'id,en,ar',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @stack('scripts')
</body>
</html>
