<footer class="aurora-footer py-5 position-relative overflow-hidden">
    <div class="footer-wave-container"></div>
    <div class="container">
        <div class="row g-4">
            {{-- Brand & About --}}
            <div class="col-lg-4 notranslate" translate="no">
                <div class="d-flex align-items-center gap-3 mb-3">
                    @php 
                        $logoWhite = \App\Models\Setting::get('site_logo_white');
                        $logoMain = \App\Models\Setting::get('site_logo');
                        
                        // Use main logo if white logo is empty OR is still the default seeder path
                        if (!$logoWhite || $logoWhite == 'images/logo_white.png') {
                            $logo = $logoMain;
                        } else {
                            $logo = $logoWhite;
                        }
                    @endphp
                    @if($logo)
                        <img src="{{ asset('storage/'.$logo) }}" height="50" alt="Logo" class="notranslate" translate="no">
                    @else
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white shadow-sm" style="width:45px;height:45px">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    @endif
                    @php
                        $layout = \App\Models\Setting::get('site_name_layout', '1');
                        if ($layout == '2') {
                            $line1 = \App\Models\Setting::get('site_name_line1', '');
                            $line2 = \App\Models\Setting::get('site_name_line2', '');
                            $footerSiteName = e($line1) . '<br>' . e($line2);
                        } else {
                            $footerSiteName = e(\App\Models\Setting::get('site_name', 'Program Studi'));
                        }
                    @endphp
                    <div class="footer-heading mb-0">{!! $footerSiteName !!}</div>
                </div>
                <p class="small mb-3 lh-lg" style="color:#94a3b8">{{ \App\Models\Setting::get('site_sub_name', '') }}</p>
                <div class="d-flex gap-2">
                    @foreach([
                        'facebook' => 'fab fa-facebook-f', 
                        'instagram' => 'fab fa-instagram', 
                        'twitter' => 'fab fa-x-twitter', 
                        'youtube' => 'fab fa-youtube', 
                        'linkedin' => 'fab fa-linkedin-in',
                        'tiktok' => 'fab fa-tiktok',
                        'whatsapp' => 'fab fa-whatsapp'
                    ] as $key => $icon)
                        @php $url = \App\Models\Setting::get("social_{$key}", '') @endphp
                        @if($url)
                            <a href="{{ $url }}" target="_blank" class="social-btn text-white">
                                <i class="{{ $icon }} fa-sm"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Link Cepat (Col 2) --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-heading">{{ __('Link Cepat') }}</div>
                <div class="row g-0">
                    @if(isset($sharedMenus['footer-menu']) && $sharedMenus['footer-menu']->items->count() > 0)
                        @php
                            $items = $sharedMenus['footer-menu']->items;
                            $count = $items->count();
                            $half = ceil($count / 2);
                            $chunks = $items->chunk($half);
                        @endphp
                        @foreach($chunks as $chunk)
                            <div class="col-6">
                                <ul class="list-unstyled small mb-0">
                                    @foreach($chunk as $item)
                                        <li class="mb-2">
                                            <a href="{{ $item->resolved_url }}" target="{{ $item->target }}">
                                                @if($item->icon) <i class="{{ $item->icon }} me-1"></i> @endif
                                                {{ $item->label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        <div class="col-6">
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                                <li class="mb-2"><a href="{{ route('about') }}">{{ __('menu.about_prodi') }}</a></li>
                                <li class="mb-2"><a href="{{ route('academic') }}">{{ __('menu.academic') }}</a></li>
                                <li class="mb-2"><a href="{{ route('curriculum') }}">{{ __('menu.curriculum') }}</a></li>
                                <li class="mb-2"><a href="{{ route('calendar') }}">{{ __('menu.calendar') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><a href="{{ route('research') }}">{{ __('menu.research') }}</a></li>
                                <li class="mb-2"><a href="{{ route('community') }}">{{ __('menu.community') }}</a></li>
                                <li class="mb-2"><a href="{{ route('gallery.index') }}">{{ __('menu.gallery') }}</a></li>
                                <li class="mb-2"><a href="{{ route('events.index') }}">{{ __('menu.agenda') }}</a></li>
                                <li class="mb-2"><a href="{{ route('contact.index') }}">{{ __('menu.contact') }}</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kontak Kami (Col 3) --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-heading">{{ __('menu.footer_contact') }}</div>
                <ul class="list-unstyled small text-white-50">
                    @if($addr = \App\Models\Setting::get('contact_address'))
                    <li class="mb-3 d-flex gap-2">
                        <i class="fas fa-map-marker-alt mt-1 text-primary flex-shrink-0"></i>
                        <span>{{ $addr }}</span>
                    </li>
                    @endif
                    @if($phone = \App\Models\Setting::get('contact_phone'))
                    <li class="mb-3">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        <a href="tel:{{ $phone }}" class="text-white-50 text-decoration-none">{{ $phone }}</a>
                    </li>
                    @endif
                    @if($email = \App\Models\Setting::get('contact_email'))
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <a href="mailto:{{ $email }}" class="text-white-50 text-decoration-none">{{ $email }}</a>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Sponsor (Col 4) --}}
            <div class="col-lg-2 col-md-6">
                <div class="footer-heading">{{ __('Sponsor') }}</div>
                <div class="d-flex flex-wrap gap-2">
                    @php $sponsors = \App\Models\Sponsor::where('is_active', true)->orderBy('order')->take(6)->get() @endphp
                    @foreach($sponsors as $sponsor)
                        <div class="bg-white p-1 rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; overflow: hidden;">
                            @if($sponsor->logo)
                                <a href="{{ $sponsor->url ?? '#' }}" target="_blank" title="{{ $sponsor->name }}">
                                    <img src="{{ asset('storage/'.$sponsor->logo) }}" alt="{{ $sponsor->name }}" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                </a>
                            @else
                                <span class="text-dark fw-bold" style="font-size: 8px;">{{ $sponsor->name }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <hr class="footer-divider my-4">
        <div class="text-center">
            <small class="notranslate text-white-50" translate="no">{{ \App\Models\Setting::get('site_copyright', '&copy; ' . date('Y') . ' ' . \App\Models\Setting::get('site_name', config('app.name')) . '. All Rights Reserved') }}</small>
        </div>
    </div>
</footer>
