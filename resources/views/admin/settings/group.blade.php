@extends('adminlte::page')

@php
    $currentGroup = $group ?? 'general';
    $groupName = $groups[$currentGroup] ?? 'Pengaturan';
    if ($currentGroup == 'profile') {
        $groupName = 'Manajemen Profil';
    }
@endphp

@section('title', 'Pengaturan: ' . $groupName)

@section('content')
<div class="container-fluid pt-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm mb-0">
                <div class="card-body py-3 border-left border-primary" style="border-width: 4px !important;">
                    <h3 class="card-title m-0 font-weight-bold text-primary"><i class="fas fa-cogs me-2"></i>Pengaturan: {{ $groupName }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Sidebar Groups -->
        <div class="col-md-3">
            @include('admin.settings._sidebar')
        </div>
        
        <!-- Setting Form -->
        <div class="col-md-9">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Form {{ $groupName }}</h3>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="group" value="{{ $currentGroup }}">
                    
                    <div class="card-body">
                        @if($currentGroup == 'general')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Website / Institusi</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sub Nama Website / Institusi</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_sub_name" class="form-control" value="{{ $settings['site_sub_name'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Singkatan Website</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_abbreviation" class="form-control" value="{{ $settings['site_abbreviation'] ?? '' }}" placeholder="Contoh: UINSSC">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Deskripsi Singkat</label>
                                <div class="col-sm-9">
                                    <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Logo Website</label>
                                <div class="col-sm-9">
                                    @if(isset($settings['site_logo']))
                                        <div class="mb-2"><img src="{{ asset('storage/' . $settings['site_logo']) }}" style="max-height: 50px;"></div>
                                    @endif
                                    <input type="file" name="site_logo" class="form-control-file">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Logo Website (Versi Putih)</label>
                                <div class="col-sm-9">
                                    @if(isset($settings['site_logo_white']))
                                        <div class="mb-2 bg-dark p-2 d-inline-block rounded"><img src="{{ asset('storage/' . $settings['site_logo_white']) }}" style="max-height: 50px;"></div>
                                    @endif
                                    <input type="file" name="site_logo_white" class="form-control-file">
                                    <small class="text-muted">Gunakan untuk area dengan latar belakang gelap (seperti footer).</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Favicon</label>
                                <div class="col-sm-9">
                                    @if(isset($settings['site_favicon']))
                                        <div class="mb-2"><img src="{{ asset('storage/' . $settings['site_favicon']) }}" style="max-height: 32px;"></div>
                                    @endif
                                    <input type="file" name="site_favicon" class="form-control-file">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Teks Copyright</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_copyright" class="form-control" value="{{ $settings['site_copyright'] ?? '' }}" placeholder="Contoh: All Rights Reserved">
                                </div>
                            </div>
                            
                        @elseif($currentGroup == 'profile')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tentang Institusi</label>
                                <div class="col-sm-9">
                                    <textarea name="about_institution" class="form-control editor" rows="5" placeholder="Deskripsi singkat tentang institusi / program studi...">{{ $settings['about_institution'] ?? '' }}</textarea>
                                    <small class="text-muted">Teks ini akan ditampilkan di halaman profil institusi.</small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Ketua Institusi <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="greeting_name" class="form-control" value="{{ $settings['greeting_name'] ?? '' }}" placeholder="Prof. Fulan bin Fulan, M.Kom." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Foto Ketua Institusi</label>
                                <div class="col-sm-9">
                                    @if(!empty($settings['kaprodi_photo']))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$settings['kaprodi_photo']) }}" alt="Foto Ketua" style="height:80px; width:80px; object-fit:cover; border-radius:50%; border:2px solid #dee2e6;">
                                            <small class="d-block text-muted mt-1">Foto saat ini. Upload baru untuk mengganti.</small>
                                        </div>
                                    @endif
                                    <input type="file" name="kaprodi_photo" class="form-control-file" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sambutan Ketua Institusi <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="greeting_text" class="form-control editor" rows="5" placeholder="Assalamualaikum wr. wb. Selamat datang di website..." required>{{ $settings['greeting_text'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">
                                    <i class="fab fa-youtube text-danger me-1"></i> URL Video Profil
                                </label>
                                <div class="col-sm-9">
                                    <input type="url" name="profile_video_url" class="form-control" value="{{ $settings['profile_video_url'] ?? '' }}" placeholder="https://www.youtube.com/watch?v=XXXXXXXXXXX">
                                    <small class="text-muted">Bisa paste URL YouTube biasa atau embed. Contoh: <code>https://www.youtube.com/watch?v=xxxxx</code></small>
                                    @if(!empty($settings['profile_video_url']))
                                        <div class="mt-2 ratio ratio-16x9" style="max-width:320px;">
                                            <iframe src="{{ $settings['profile_video_url'] }}" allowfullscreen frameborder="0" style="border-radius:8px;"></iframe>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Visi Institusi <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="vision" class="form-control editor" rows="4" required>{{ $settings['vision'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Misi Institusi <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="mission" class="form-control editor" rows="6" required>{{ $settings['mission'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status Akreditasi</label>
                                <div class="col-sm-9">
                                    <input type="text" name="accreditation" class="form-control" value="{{ $settings['accreditation'] ?? '' }}" placeholder="Contoh: A (Unggul)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sertifikat Akreditasi</label>
                                <div class="col-sm-9">
                                    @if(!empty($settings['cert_accreditation']))
                                        <div class="mb-2">
                                            @if(Str::endsWith($settings['cert_accreditation'], ['.jpg','.jpeg','.png','.webp']))
                                                <img src="{{ asset('storage/'.$settings['cert_accreditation']) }}" alt="Sertifikat Akreditasi" style="max-height:120px; border-radius:6px; border:1px solid #dee2e6;">
                                            @else
                                                <a href="{{ asset('storage/'.$settings['cert_accreditation']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf mr-1"></i> Lihat Sertifikat Saat Ini
                                                </a>
                                            @endif
                                            <small class="d-block text-muted mt-1">File saat ini. Upload baru untuk mengganti.</small>
                                        </div>
                                    @endif
                                    <input type="file" name="cert_accreditation" class="form-control-file" accept="image/*,.pdf">
                                    <small class="text-muted">Format: JPG, PNG, PDF. Maks 5MB.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label pt-2">Sertifikasi Lainnya</label>
                                <div class="col-sm-9">
                                    <div id="cert-others-list">
                                        @php
                                            $certOthers = json_decode($settings['cert_others'] ?? '[]', true) ?? [];
                                        @endphp
                                        @forelse($certOthers as $idx => $cert)
                                        <div class="cert-other-row card card-body p-3 mb-3 border" style="border-radius:10px;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong class="text-sm text-muted">Sertifikasi #{{ $idx + 1 }}</strong>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-cert-row"><i class="fas fa-trash"></i></button>
                                            </div>
                                            <input type="hidden" name="cert_other_existing[]" value="{{ $cert['file'] ?? '' }}">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Nama / Jenis Sertifikasi</label>
                                                <input type="text" name="cert_other_name[]" class="form-control form-control-sm" value="{{ $cert['name'] ?? '' }}" placeholder="Contoh: ISO 9001:2015, LAMSAMA, dll." required>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Dokumen Sertifikasi</label>
                                                @if(!empty($cert['file']))
                                                    <div class="mb-1">
                                                        @if(Str::endsWith($cert['file'], ['.jpg','.jpeg','.png','.webp']))
                                                            <img src="{{ asset('storage/'.$cert['file']) }}" style="max-height:60px; border-radius:4px; border:1px solid #dee2e6;">
                                                        @else
                                                            <a href="{{ asset('storage/'.$cert['file']) }}" target="_blank" class="btn btn-xs btn-outline-secondary btn-sm"><i class="fas fa-file mr-1"></i> Lihat File Saat Ini</a>
                                                        @endif
                                                        <small class="text-muted ml-1">Upload baru untuk mengganti.</small>
                                                    </div>
                                                @endif
                                                <input type="file" name="cert_other_file[]" class="form-control-file" accept="image/*,.pdf">
                                                <small class="text-muted">JPG, PNG, PDF. Maks 5MB.</small>
                                            </div>
                                        </div>
                                        @empty
                                        <p class="text-muted small mb-2" id="cert-empty-msg">Belum ada sertifikasi. Klik tombol di bawah untuk menambahkan.</p>
                                        @endforelse
                                    </div>
                                    <button type="button" id="add-cert-row" class="btn btn-sm btn-outline-success mt-1">
                                        <i class="fas fa-plus mr-1"></i> Tambah Sertifikasi
                                    </button>
                                </div>
                            </div>
                            
                        @elseif($currentGroup == 'contact')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email Utama</label>
                                <div class="col-sm-9">
                                    <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="info@kampus.ac.id">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-9">
                                    <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="(021) 1234567">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">WhatsApp</label>
                                <div class="col-sm-9">
                                    <input type="text" name="contact_whatsapp" class="form-control" value="{{ $settings['contact_whatsapp'] ?? '' }}" placeholder="6281234567890">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Alamat Lengkap</label>
                                <div class="col-sm-9">
                                    <textarea name="contact_address" class="form-control" rows="3">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Embed Google Maps (Iframe)</label>
                                <div class="col-sm-9">
                                    <textarea name="contact_maps" class="form-control" rows="4">{{ $settings['contact_maps'] ?? '' }}</textarea>
                                </div>
                            </div>

                        @elseif($currentGroup == 'social')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><i class="fab fa-facebook text-primary me-2"></i> Facebook URL</label>
                                <div class="col-sm-9">
                                    <input type="url" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><i class="fab fa-instagram text-danger me-2"></i> Instagram URL</label>
                                <div class="col-sm-9">
                                    <input type="url" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><i class="fab fa-youtube text-danger me-2"></i> YouTube URL</label>
                                <div class="col-sm-9">
                                    <input type="url" name="social_youtube" class="form-control" value="{{ $settings['social_youtube'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><i class="fab fa-twitter text-info me-2"></i> Twitter / X URL</label>
                                <div class="col-sm-9">
                                    <input type="url" name="social_twitter" class="form-control" value="{{ $settings['social_twitter'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><i class="fab fa-tiktok text-dark me-2"></i> TikTok URL</label>
                                <div class="col-sm-9">
                                    <input type="url" name="social_tiktok" class="form-control" value="{{ $settings['social_tiktok'] ?? '' }}">
                                </div>
                            </div>

                        @elseif($currentGroup == 'seo')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Meta Data Keywords</label>
                                <div class="col-sm-9">
                                    <textarea name="seo_keywords" class="form-control" rows="3" placeholder="kampus, universitas, pendidikan, terbaik...">{{ $settings['seo_keywords'] ?? '' }}</textarea>
                                    <small class="text-muted">Pisahkan dengan koma.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Meta Data Author</label>
                                <div class="col-sm-9">
                                    <input type="text" name="seo_author" class="form-control" value="{{ $settings['seo_author'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Google Analytics ID</label>
                                <div class="col-sm-9">
                                    <input type="text" name="seo_google_analytics" class="form-control" value="{{ $settings['seo_google_analytics'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                                </div>
                            </div>

                        @elseif($currentGroup == 'academic')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label pt-2">File Kalender Akademik (PDF)</label>
                                <div class="col-sm-9">
                                    @if(!empty($settings['academic_calendar_pdf']))
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/'.$settings['academic_calendar_pdf']) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-file-pdf mr-1"></i> Lihat File Saat Ini
                                            </a>
                                            <small class="d-block text-muted mt-1">Gantilah dengan mengunggah file baru di bawah ini.</small>
                                        </div>
                                    @endif
                                    <input type="file" name="academic_calendar_pdf" class="form-control-file" accept=".pdf">
                                    <small class="text-muted">Format: PDF. Maksimum 10MB.</small>
                                </div>
                            </div>
                            <hr>
                            <div class="alert alert-info border-0 shadow-sm rounded-4 small">
                                <i class="fas fa-info-circle mr-2"></i>
                                Modul ini mengelola file download kalender akademik. Untuk mengelola <strong>data agenda kalender</strong> (tabel yang tampil di website), silakan gunakan <a href="{{ route('admin.academic-calendars.index') }}" class="font-weight-bold">Modul Kalender Akademik</a>.
                            </div>
                        @elseif($currentGroup == 'appearance')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Skema Tema Website</label>
                                <div class="col-sm-9">
                                    <h6 class="mb-3 font-weight-bold text-muted"><i class="fas fa-layer-group mr-2 text-secondary"></i>Tema Standar</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? 'navy-blue-balakutak') == 'navy-blue-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_navy').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #0a192f 0%, #112240 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_navy" name="site_theme" value="navy-blue-balakutak" {{ ($settings['site_theme'] ?? 'navy-blue-balakutak') == 'navy-blue-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_navy" class="custom-control-label small">NavyBlue</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'green-gold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_green').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #064e3b 0%, #d97706 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_green" name="site_theme" value="green-gold-balakutak" {{ ($settings['site_theme'] ?? '') == 'green-gold-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_green" class="custom-control-label small">GreenGold</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'brown-yellow-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_brown').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #3E2723 0%, #FFD700 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_brown" name="site_theme" value="brown-yellow-balakutak" {{ ($settings['site_theme'] ?? '') == 'brown-yellow-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_brown" class="custom-control-label small">BrownYellow</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'maroon-red-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_maroon_red').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #4A0000 0%, #FF3131 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_maroon_red" name="site_theme" value="maroon-red-balakutak" {{ ($settings['site_theme'] ?? '') == 'maroon-red-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_maroon_red" class="custom-control-label small">MaroonRed</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'black-silver-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_black_silver').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #212529 0%, #adb5bd 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_black_silver" name="site_theme" value="black-silver-balakutak" {{ ($settings['site_theme'] ?? '') == 'black-silver-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_black_silver" class="custom-control-label small">BlackSilver</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'maroon-brown-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_maroon_brown').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:60px; background: linear-gradient(135deg, #692C1C 0%, #8D6E63 100%);">
                                                        <img src="{{ \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('images/logo.png') }}" style="max-height: 40px; width: auto;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_maroon_brown" name="site_theme" value="maroon-brown-balakutak" {{ ($settings['site_theme'] ?? '') == 'maroon-brown-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_maroon_brown" class="custom-control-label small">MaroonBrown</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="mb-3 font-weight-bold text-success"><i class="fas fa-crown mr-2"></i>Tema Premium</h6>
                                    <div class="row">
                                        <!-- Aurora Glass -->
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'aurora-glass-balakutak' ? 'border-success shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_aurora_glass').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/aurora-glass.png') }}'); background-size: cover; background-position: center; border: 1px solid #eee;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_aurora_glass" name="site_theme" value="aurora-glass-balakutak" {{ ($settings['site_theme'] ?? '') == 'aurora-glass-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_aurora_glass" class="custom-control-label small">AuroraGlass</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Royal Purple (Original Premium) -->
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'royal-purple-balakutak' ? 'border-success shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_royal_purple').checked = true">
                                                <div class="card-body text-center p-3">
                                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/royal-purple.png') }}'); background-size: cover; background-position: center; border: 1px solid #eee;">
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="theme_royal_purple" name="site_theme" value="royal-purple-balakutak" {{ ($settings['site_theme'] ?? '') == 'royal-purple-balakutak' ? 'checked' : '' }}>
                                                        <label for="theme_royal_purple" class="custom-control-label small">RoyalPurple</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="mb-3 font-weight-bold text-primary"><i class="fas fa-university mr-2"></i>Tema World University</h6>
                                    
                                    <div class="mb-4 pl-3 border-left" style="border-left-width: 4px !important; border-color: #002147 !important;">
                                        <h6 class="mb-3 font-weight-bold" style="color: #002147;"><i class="fas fa-university mr-2"></i>Oxford</h6>
                                        <div class="row">
                                            <!-- Oxford Navy Gold -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-navygold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_oxford_navygold').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/oxford-luxury.png') }}'); background-size: cover; background-position: center; border: 1px solid #002147;">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_oxford_navygold" name="site_theme" value="oxford-luxury-navygold-balakutak" {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-navygold-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_oxford_navygold" class="custom-control-label small">OxfordLuxury-NavyGold <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Oxford Red Gold -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-redgold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_oxford_redgold').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/oxford-luxury.png') }}'); background-size: cover; background-position: center; border: 1px solid #800000; filter: hue-rotate(140deg) saturate(1.2);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_oxford_redgold" name="site_theme" value="oxford-luxury-redgold-balakutak" {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-redgold-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_oxford_redgold" class="custom-control-label small">OxfordLuxury-RedGold <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Oxford Green Gold -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-greengold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_oxford_greengold').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/oxford-luxury.png') }}'); background-size: cover; background-position: center; border: 1px solid #004d40; filter: hue-rotate(80deg) saturate(1.2);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_oxford_greengold" name="site_theme" value="oxford-luxury-greengold-balakutak" {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-greengold-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_oxford_greengold" class="custom-control-label small">OxfordLuxury-GreenGold <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Oxford Black Gold -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-blackgold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_oxford_blackgold').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/oxford-luxury.png') }}'); background-size: cover; background-position: center; border: 1px solid #1a1a1a; filter: grayscale(1) brightness(0.6);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_oxford_blackgold" name="site_theme" value="oxford-luxury-blackgold-balakutak" {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-blackgold-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_oxford_blackgold" class="custom-control-label small">OxfordLuxury-BlackGold <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Oxford Brown Gold -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-browngold-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_oxford_browngold').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/oxford-luxury.png') }}'); background-size: cover; background-position: center; border: 1px solid #5D4037; filter: sepia(0.5) brightness(0.7) hue-rotate(-20deg);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_oxford_browngold" name="site_theme" value="oxford-luxury-browngold-balakutak" {{ ($settings['site_theme'] ?? '') == 'oxford-luxury-browngold-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_oxford_browngold" class="custom-control-label small">OxfordLuxury-BrownGold <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pl-3 border-left" style="border-left-width: 4px !important; border-color: #8C1515 !important;">
                                        <h6 class="mb-3 font-weight-bold" style="color: #8C1515;"><i class="fas fa-graduation-cap mr-2"></i>Stanford</h6>
                                        <div class="row">
                                            <!-- Stanford Grow Brown -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-brown-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_brown').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #5D4037; filter: sepia(0.5) brightness(0.7) hue-rotate(-20deg);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_brown" name="site_theme" value="stanford-grow-brown-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-brown-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_brown" class="custom-control-label small">StanfordGrow-Brown <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Stanford Grow Navy -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-navy-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_navy').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #002147; filter: saturate(0.5) brightness(0.8) sepia(1) hue-rotate(180deg);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_navy" name="site_theme" value="stanford-grow-navy-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-navy-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_navy" class="custom-control-label small">StanfordGrow-Navy <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Stanford Grow Green -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-green-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_green').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #064e3b; filter: saturate(0.8) hue-rotate(80deg);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_green" name="site_theme" value="stanford-grow-green-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-green-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_green" class="custom-control-label small">StanfordGrow-Green <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Stanford Grow Red -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-red-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_red').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #c62828;">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_red" name="site_theme" value="stanford-grow-red-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-red-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_red" class="custom-control-label small">StanfordGrow-Red <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Stanford Grow GoldenOrange -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-goldenorange-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_goldenorange').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #f57c00; filter: saturate(1.5) hue-rotate(-20deg);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_goldenorange" name="site_theme" value="stanford-grow-goldenorange-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-goldenorange-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_goldenorange" class="custom-control-label small">StanfordGrow-GoldenOrange <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Stanford Grow BlackSilver -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 {{ ($settings['site_theme'] ?? '') == 'stanford-grow-blacksilver-balakutak' ? 'border-primary shadow' : 'border-light shadow-sm' }}" style="cursor:pointer; border-width: 2px;" onclick="document.getElementById('theme_stanford_grow_blacksilver').checked = true">
                                                    <div class="card-body text-center p-3">
                                                        <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height:100px; background: url('{{ asset('images/themes/thumbnails/stanford-grow.png') }}'); background-size: cover; background-position: center; border: 1px solid #1a1a1a; filter: grayscale(1) brightness(0.6);">
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="theme_stanford_grow_blacksilver" name="site_theme" value="stanford-grow-blacksilver-balakutak" {{ ($settings['site_theme'] ?? '') == 'stanford-grow-blacksilver-balakutak' ? 'checked' : '' }}>
                                                            <label for="theme_stanford_grow_blacksilver" class="custom-control-label small">StanfordGrow-Black Silver <span class="badge bg-warning text-dark ml-1" style="font-size:0.6rem;">PREMIUM</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted small mt-1">Pilih tema untuk mengubah desain dasar landing page website Anda.</p>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Warna Utama (Primary)</label>
                                <div class="col-sm-9">
                                    <input type="color" name="color_primary" class="form-control" value="{{ $settings['color_primary'] ?? '#007bff' }}" style="height: 40px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Warna Sekunder (Secondary)</label>
                                <div class="col-sm-9">
                                    <input type="color" name="color_secondary" class="form-control" value="{{ $settings['color_secondary'] ?? '#6c757d' }}" style="height: 40px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Custom CSS</label>
                                <div class="col-sm-9">
                                    <textarea name="custom_css" class="form-control text-monospace" rows="5" placeholder="body { ... }">{{ $settings['custom_css'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan {{ $groupName }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame { border-radius: 8px; border-color: #dee2e6; box-shadow: none; }
    .note-toolbar { background: #f8f9fa; border-bottom: 1px solid #dee2e6; border-radius: 8px 8px 0 0; }
</style>
@endpush

@if($currentGroup == 'profile')
@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Summernote
    $('.editor').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onInit: function() {
                $(this).next('.note-editor').addClass('card shadow-none mb-0');
            }
        }
    });

    const list    = document.getElementById('cert-others-list');
    const addBtn  = document.getElementById('add-cert-row');
    if (!addBtn) return;

    function renumber() {
        list.querySelectorAll('.cert-other-row strong').forEach(function (el, i) {
            el.textContent = 'Sertifikasi #' + (i + 1);
        });
        const emptyMsg = document.getElementById('cert-empty-msg');
        if (emptyMsg) emptyMsg.style.display = list.querySelectorAll('.cert-other-row').length ? 'none' : '';
    }

    addBtn.addEventListener('click', function () {
        const emptyMsg = document.getElementById('cert-empty-msg');
        if (emptyMsg) emptyMsg.style.display = 'none';

        const idx = list.querySelectorAll('.cert-other-row').length;
        const row = document.createElement('div');
        row.className = 'cert-other-row card card-body p-3 mb-3 border';
        row.style.borderRadius = '10px';
        row.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong class="text-sm text-muted">Sertifikasi #${idx + 1}</strong>
                <button type="button" class="btn btn-sm btn-outline-danger remove-cert-row"><i class="fas fa-trash"></i></button>
            </div>
            <input type="hidden" name="cert_other_existing[]" value="">
            <div class="form-group mb-2">
                <label class="small font-weight-bold">Nama / Jenis Sertifikasi</label>
                <input type="text" name="cert_other_name[]" class="form-control form-control-sm" placeholder="Contoh: ISO 9001:2015, LAMSAMA, dll." required>
            </div>
            <div class="form-group mb-0">
                <label class="small font-weight-bold">Dokumen Sertifikasi</label>
                <input type="file" name="cert_other_file[]" class="form-control-file" accept="image/*,.pdf">
                <small class="text-muted">JPG, PNG, PDF. Maks 5MB.</small>
            </div>`;
        list.appendChild(row);
        row.querySelector('.remove-cert-row').addEventListener('click', function () {
            row.remove(); renumber();
        });
    });

    // Bind existing remove buttons
    list.querySelectorAll('.remove-cert-row').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.cert-other-row').remove(); renumber();
        });
    });
});
</script>
@endpush
@endif
