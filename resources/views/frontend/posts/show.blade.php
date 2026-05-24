@extends('layouts.frontend')

@push('title'){{ $post->title }} - @endpush

@section('content')
    {{-- Article Header --}}
    <section class="page-header-premium mb-5" style="background-image: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('{{ $post->featured_image_url }}'); background-size: cover; background-position: center; border-bottom: none !important;">
        <div class="page-header-pattern"></div>
        <div class="page-header-logo">
            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo">
        </div>
        <div class="container position-relative z-10 py-4">
            <div class="text-center" data-aos="zoom-in">
                <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-center">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">{{ __('menu.news_and_articles') }}</a></li>
                        @if($post->category)
                            <li class="breadcrumb-item"><a href="{{ route('posts.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a></li>
                        @endif
                    </ol>
                </nav>
                
                @if($post->category)
                    <span class="badge-theme-pill mb-4 d-inline-block">
                        {{ $post->category->name }}
                    </span>
                @endif
                
                <h1 class="display-3 fw-bold text-white mb-4 letter-spacing-n1" style="line-height:1.1;">{{ $post->title }}</h1>
                
                <div class="article-meta-row d-flex justify-content-center align-items-center gap-4 flex-wrap text-white">
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=D4AF37&color=fff" class="rounded-circle border border-white border-2" width="40">
                        <span class="fw-bold">{{ $post->user->name }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 opacity-90">
                        <i class="far fa-calendar-alt text-theme-accent"></i>
                        <span>{{ $post->published_at?->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 opacity-90">
                        <i class="far fa-eye text-theme-accent"></i>
                        <span>{{ number_format($post->views) }} {{ __('views') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        <div class="row g-5">
            {{-- Main Content --}}
            <div class="col-12">
                <article class="article-content bg-white p-4 p-md-5 rounded-4 shadow-sm" data-aos="fade-up">

                    {{-- Author & Navigation (In front of text) --}}
                    <div class="float-lg-end ms-lg-5 mb-4 px-3 px-lg-0" style="width: 100%; max-width: 300px; z-index: 10; position: relative;" data-aos="fade-left">
                        
                        <div class="bg-white rounded-4 shadow p-4 mb-4 text-center border-0" style="border-radius: 20px !important;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=0D6EFD&color=fff&size=128" class="rounded-circle shadow-sm mx-auto mb-3" width="80" style="border: 3px solid #fff;">
                            <h5 class="fw-bold mb-1" style="font-size: 1.1rem; color: #333;">{{ $post->user->name }}</h5>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Penulis / Administrator</p>
                        </div>

                        <div class="bg-white rounded-4 shadow p-4 text-center d-grid gap-3 border-0" style="border-radius: 20px !important;">
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill fw-medium d-flex justify-content-center align-items-center gap-2" style="border-color: #6c757d; color: #495057;">
                                <i class="fas fa-list"></i> Kembali ke Daftar
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill fw-medium d-flex justify-content-center align-items-center gap-2" style="background-color: #0d6efd; border: none;">
                                <i class="fas fa-home"></i> Halaman Utama
                            </a>
                        </div>
                    </div>
                    
                    {{-- Excerpt --}}
                    @if($post->excerpt)
                        <div class="lead fw-semibold text-muted mb-5 ps-4 border-start border-primary border-4">
                            {{ $post->excerpt }}
                        </div>
                    @endif

                    {{-- Body --}}
                    <div class="post-body lh-lg" style="font-size: 1.1rem; text-align: justify;">
                        @safeHtml($post->content)
                    </div>

                    {{-- Tags --}}
                    @if($post->tags->count() > 0)
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="fw-bold mb-3"><i class="fas fa-tags me-2"></i>Topik Terkait:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- SDGs --}}
                    @if($post->sdgs && (!is_array($post->sdgs) ? json_decode($post->sdgs, true) : $post->sdgs))
                        @php
                            $sdgsArray = !is_array($post->sdgs) ? json_decode($post->sdgs, true) : $post->sdgs;
                        @endphp
                        @if(count($sdgsArray) > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="fw-bold mb-3"><i class="fas fa-globe me-2 text-success"></i>Keterkaitan SDGs:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($sdgsArray as $sdg)
                                        <span class="badge bg-success bg-gradient bg-opacity-75 rounded-pill px-3 py-2" style="font-size: 0.85rem;"><i class="fas fa-leaf me-1"></i> {{ $sdg }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- Share --}}
                    <div class="mt-5 p-4 bg-light rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <span class="fw-bold"><i class="fas fa-share-alt me-2"></i>Bagikan Artikel:</span>
                        <div class="share-buttons d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-info text-white rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-twitter"></i></a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-success rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px;"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </article>

                {{-- Related Posts --}}
                @if($related->count() > 0)
                    <div class="related-posts mt-5" data-aos="fade-up">
                        <h4 class="fw-bold mb-4">{{ __('menu.news_and_articles') }} Lainnya</h4>
                        <div class="row g-4">
                            @foreach($related as $rel)
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                        <div style="height: 120px;">
                                            <img src="{{ $rel->featured_image_url }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold small mb-2">
                                                <a href="{{ route('posts.show', $rel->slug) }}" class="text-dark text-decoration-none">
                                                    {{ Str::limit($rel->title, 45) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted d-block" style="font-size: .75rem;">
                                                <i class="fas fa-calendar-alt me-1"></i> {{ $rel->published_at?->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .post-body {
        position: relative;
    }
    
    .post-body p:has(img), .post-body p > img {
        text-align: center;
        clear: both;
    }

    .post-body img, .post-body figure.image > img { 
        max-width: 100% !important; 
        height: auto !important; 
        object-fit: contain;
        border-radius: 1rem; 
        margin: 1.5rem auto !important; 
        display: block !important;
        float: none !important;
    }
    
    .post-body figure.image { 
        width: 100% !important; 
        margin: 1.5rem auto !important; 
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        float: none !important;
    }
    .post-body figure.image figcaption {
        text-align: center;
        color: #6c757d;
        font-size: 0.875em;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }
    .post-body blockquote { 
        border-left: 5px solid #0d6efd; 
        padding: 1rem 2rem; 
        background: #f8f9fa; 
        font-style: italic; 
        border-radius: 0 1rem 1rem 0; 
    }
</style>
@endpush
