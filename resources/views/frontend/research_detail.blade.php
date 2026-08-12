@extends('layouts.frontend')

@push('title'){{ $post->title }} - @endpush

@section('content')
    {{-- Research Header --}}
    <section class="page-header-premium mb-5" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ $post->featured_image_url }}'); background-size: cover; background-position: center; border-bottom: none !important;">
        <div class="page-header-pattern"></div>
        <div class="page-header-logo">
            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo">
        </div>
        <div class="container position-relative z-10 py-4">
            <div class="text-center" data-aos="zoom-in">
                <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-center">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Beranda') }}</a></li>
                        @if($post->type === 'research')
                            <li class="breadcrumb-item"><a href="{{ route('research') }}">{{ __('Penelitian') }}</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('community') }}">{{ __('Pengabdian') }}</a></li>
                        @endif
                        <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                    </ol>
                </nav>
                
                <span class="badge bg-primary rounded-pill mb-4 px-3 py-2 shadow-sm text-uppercase letter-spacing-1" style="font-size: 0.75rem;">
                    {{ $post->type === 'research' ? 'Hasil Penelitian' : 'Pengabdian Masyarakat' }}
                </span>
                
                <h1 class="display-4 fw-bold text-white mb-4 letter-spacing-n1" style="line-height:1.2; max-width: 900px; margin: 0 auto;">{{ $post->title }}</h1>
                
                <div class="article-meta-row d-flex justify-content-center align-items-center gap-4 flex-wrap text-white mt-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user-tie text-primary"></i>
                        </div>
                        <span class="fw-bold">{{ $post->author ?? 'Tutor/Dosen' }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 opacity-90">
                        <i class="far fa-calendar-alt text-warning"></i>
                        <span>Tahun: {{ $post->year ?? date('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-5 mt-n5 position-relative z-20">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="article-content bg-white p-4 p-md-5 rounded-4 shadow-lg border-0" data-aos="fade-up">

                    <div class="row g-5">
                        <div class="col-lg-8">
                            {{-- Abstract --}}
                            @if($post->abstract)
                                <div class="mb-5">
                                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-align-left me-2"></i>Abstrak / Ringkasan</h5>
                                    <div class="bg-light p-4 rounded-4 italic text-secondary lh-lg" style="font-style: italic; border-left: 4px solid #0d6efd;">
                                        {{ $post->abstract }}
                                    </div>
                                </div>
                            @endif

                            {{-- Content Body --}}
                            <div class="post-body lh-lg" style="font-size: 1.1rem; text-align: justify; color: #444;">
                                @safeHtml($post->content)
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {{-- Sidebar Info --}}
                            <div class="sticky-top" style="top: 100px;">
                                @if($post->file_path)
                                <div class="bg-primary bg-gradient text-white p-4 rounded-4 shadow mb-4">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-file-pdf fa-4x opacity-50"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Dokumen Publikasi</h6>
                                    <p class="small opacity-80 mb-3">Unduh dokumen lengkap hasil {{ $post->type === 'research' ? 'penelitian' : 'pengabdian' }} ini.</p>
                                    <a href="{{ asset('storage/' . $post->file_path) }}" target="_blank" class="btn btn-light w-100 rounded-pill fw-bold py-2 shadow-sm">
                                        <i class="fas fa-download me-2"></i> Unduh PDF
                                    </a>
                                </div>
                                @endif

                                @if($post->external_link)
                                <div class="bg-dark text-white p-4 rounded-4 shadow mb-4">
                                    <h6 class="fw-bold mb-2">Link Eksternal</h6>
                                    <p class="small opacity-70 mb-3">Lihat referensi atau link terkait pada database publikasi luar.</p>
                                    <a href="{{ $post->external_link }}" target="_blank" class="btn btn-outline-light w-100 rounded-pill fw-bold py-2">
                                        <i class="fas fa-external-link-alt me-2"></i> Buka Link
                                    </a>
                                </div>
                                @endif

                                <div class="bg-light p-4 rounded-4">
                                    <h6 class="fw-bold mb-3">Bagikan Meta:</h6>
                                    <div class="d-flex gap-2">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-facebook-f"></i></a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-info text-white rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-twitter"></i></a>
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-success rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-whatsapp"></i></a>
                                    </div>
                                    <hr>
                                    <a href="{{ $post->type === 'research' ? route('research') : route('community') }}" class="btn btn-link btn-sm text-secondary p-0 d-block text-start">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .post-body p:has(img), .post-body p > img { text-align: center; clear: both; }
    .post-body img { max-width: 100% !important; height: auto !important; border-radius: 1rem; margin: 1.5rem auto !important; display: block !important; }
    .page-header-premium { min-height: 400px; display: flex; align-items: center; }
</style>
@endpush
