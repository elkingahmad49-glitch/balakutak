<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
        
        <style>
            .sidebar-cms-logo .logo-for-light { display: none; }
            .sidebar-cms-logo .logo-for-dark { display: inline-block; }
            [class*="sidebar-light-"] .sidebar-cms-logo .logo-for-dark { display: none; }
            [class*="sidebar-light-"] .sidebar-cms-logo .logo-for-light { display: inline-block; }
            [class*="sidebar-light-"] .adminlte-version-text { color: #6c757d !important; }
            body.dark-mode .sidebar-cms-logo .logo-for-light { display: none !important; }
            body.dark-mode .sidebar-cms-logo .logo-for-dark { display: inline-block !important; }
        </style>
        <div class="sidebar-cms-logo text-center mt-4 mb-4">
            <hr class="mx-3 mt-0 mb-3" style="border-top: 1px solid rgba(128,128,128,0.2);">
            @php
                $siteName = \App\Models\Setting::get('site_name', env('APP_NAME', 'Prodi CMS'));
                $siteLogoDarkUrl = asset('images/logo-dark-bg.png');
                $siteLogoLightUrl = asset('images/logo-light-bg.png');
            @endphp
            <img src="{{ $siteLogoDarkUrl }}" alt="{{ $siteName }}" class="img-fluid px-3 logo-for-dark" style="max-height: 50px; opacity: 0.9;">
            <img src="{{ $siteLogoLightUrl }}" alt="{{ $siteName }}" class="img-fluid px-3 logo-for-light" style="max-height: 50px; opacity: 0.9;">
            <div class="mt-3">
                <span class="adminlte-version-text badge rounded-pill" style="font-size: 0.8rem; letter-spacing: 0.5px; font-weight: 600; background-color: rgba(255,255,255,0.1); padding: 5px 12px; border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);">
                    Version 2.0.1
                </span>
            </div>
        </div>
    </div>

</aside>
