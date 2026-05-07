<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { box-sizing: border-box; }
        body, html { 
            margin: 0; padding: 0; height: 100%; width: 100%; overflow: hidden;
            font-family: 'Outfit', sans-serif;
        }
        /* Hide Google Translate top bar/arrow */
        .goog-te-banner-frame, #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }
        iframe.skiptranslate { display: none !important; }
        .goog-text-highlight { background: none !important; box-shadow: none !important; }

        {{-- Aggressive Fullscreen Background Fix --}}
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(rgba(30, 27, 75, 0.4), rgba(30, 27, 75, 0.4)), url('{{ asset('images/login-bg-balakutak.jpg') }}?v={{ time() }}') no-repeat center center fixed !important;
            background-size: cover !important;
            z-index: -1;
            transform: scale(1);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 antialiased">
    
    <div class="relative z-20 w-full flex flex-col items-center justify-center py-8" style="max-width: 800px; margin: 0 auto;">
        {{-- Professional Login Card --}}
        <div class="w-full flex shadow-[0_30px_100px_rgba(0,0,0,0.5)] bg-white min-h-[620px] border border-white/20" 
             style="border-radius: 48px; overflow: hidden;">
        
            <!-- Left Side - Branding -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 text-white flex-col justify-center p-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col justify-center items-center text-center">
                    {{-- Custom Sized Branding Logo (2.5cm Height) --}}
                    <div class="mb-6 flex items-center justify-center">
                        @php $siteLogo = \App\Models\Setting::get('site_logo') @endphp
                        @if($siteLogo)
                            <img src="{{ asset('storage/'.$siteLogo) }}?v={{ time() }}" alt="Site Logo" style="height: 95px !important; width: auto; filter: brightness(0) invert(1);" class="drop-shadow-2xl opacity-90">
                        @else
                            <img src="{{ asset('images/balakutak-logo-official.png') }}" alt="Default Logo" style="height: 90px !important; width: auto; filter: brightness(0) invert(1);" class="drop-shadow-2xl opacity-90">
                        @endif
                    </div>

                    <h2 class="text-lg font-bold mb-1 leading-tight drop-shadow-xl tracking-tight">{{ \App\Models\Setting::get('site_name', 'Your Website Name') }}</h2>
                    <p class="text-indigo-100/70 text-[9px] font-medium drop-shadow-md leading-relaxed max-w-[180px] uppercase tracking-widest">{{ \App\Models\Setting::get('site_sub_name', 'Your Website Subname') }}</p>
                </div>
                
                {{-- Decorative Glow --}}
                <div class="absolute -bottom-24 -left-20 w-80 h-80 bg-purple-500/20 rounded-full blur-[100px]"></div>
            </div>

            <!-- Right Side - Login Form (With Large Captcha) -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-white relative">
                <div class="w-full max-w-sm">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-slate-900 mb-1">Welcome Back</h1>
                        <p class="text-slate-400 text-sm">Please sign in to your account</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                class="block w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-800 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500/50 transition-all duration-300 outline-none" 
                                placeholder="you@example.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-2 ml-1">
                                <label for="password" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-[9px] font-bold text-indigo-500 hover:text-indigo-600 uppercase tracking-tighter transition-colors">Forgot?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="current-password" 
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-800 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500/50 transition-all duration-300 outline-none pr-12" 
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <button type="button" onclick="togglePassword()" class="text-slate-300 hover:text-indigo-600 transition-colors focus:outline-none focus:ring-0">
                                        <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg id="eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Image Captcha Block -->
                        <div class="space-y-3 pt-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Human Verification</label>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-16 bg-white rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center p-0.5 relative shadow-inner">
                                    <img src="{{ route('captcha.generate') }}?v={{ time() }}" id="captcha-img" class="h-full w-full object-cover rounded-lg" alt="Captcha">
                                </div>
                                <button type="button" onclick="refreshCaptcha()" title="Refresh Code" class="h-10 w-10 flex items-center justify-center bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-500 hover:text-white hover:bg-indigo-600 transition-all shadow-sm active:scale-95">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                            </div>
                            <input id="captcha" type="text" name="captcha" required 
                                class="block w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-800 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500/50 transition-all duration-300 outline-none"
                                placeholder="Type the code above">
                            <x-input-error :messages="$errors->get('captcha')" class="mt-1" />
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full relative overflow-hidden group py-4 px-6 bg-indigo-600 text-white rounded-xl font-black text-sm shadow-xl shadow-indigo-600/20 hover:scale-[1.01] active:scale-[0.98] transition-all duration-200">
                            <span class="relative z-10 tracking-widest uppercase">Sign In</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Horizontal Exterior Branding Below Card (2cm Gap) --}}
        <div class="mt-[76px] flex flex-row items-center justify-center gap-4 animate-fade-in opacity-40 hover:opacity-100 transition-opacity duration-700">
            @php 
                $logoWhite = \App\Models\Setting::get('site_logo_white');
                $logoMain = \App\Models\Setting::get('site_logo');
                $siteLogo = (!$logoWhite || $logoWhite == 'images/logo_white.png') ? $logoMain : $logoWhite;
            @endphp
            <img src="{{ $siteLogo ? asset('storage/'.$siteLogo) : asset('images/balakutak-logo-official.png') }}" 
                 alt="Logo" 
                 style="height: 57px !important; width: auto;" 
                 class="{{ $siteLogo ? '' : 'grayscale contrast-125' }}">
            <div class="px-3 py-1 bg-white/5 text-white/30 rounded-full text-[8px] font-black tracking-[0.3em] uppercase border border-white/5 whitespace-nowrap">
                V.1.0.0
            </div>
        </div>
    </div>

    <script>
        function refreshCaptcha() {
            const img = document.getElementById('captcha-img');
            img.src = "{{ route('captcha.generate') }}?id=" + Math.random();
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
