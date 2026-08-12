@extends('layouts.frontend')

@push('title')
{{ $page->title }} -
@endpush

@section('content')
@if($page->is_builder)
    <div class="page-builder-content">
        @safeHtml($processedContent)
    </div>
@else
    <div class="page-header-premium py-5 text-white position-relative overflow-hidden">
        <div class="page-header-pattern"></div>
        <div class="container py-4 position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2 text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="fas fa-home me-1"></i>{{ __('Beranda') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $page->title }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-0">{{ $page->title }}</h1>
                </div>
            </div>
        </div>
        <div class="page-header-logo">
            @php $logo = \App\Models\Setting::get('site_logo') @endphp
            @if($logo)
                <img src="{{ asset('storage/'.$logo) }}" alt="Logo">
            @endif
        </div>
    </div>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-up">
                    @if($page->featured_image)
                    <div class="mb-5 text-center">
                        <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 500px; object-fit: cover;">
                    </div>
                    @endif

                    <div class="page-content bg-white p-4 p-lg-5 rounded-4 shadow-sm border">
                        <div class="text-dark leading-relaxed">
                            @safeHtml($processedContent)
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill px-5">
                            <i class="fas fa-arrow-left me-2"></i> {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection

@push('styles')
<style>
    {!! $builderCss !!}
    .leading-relaxed { line-height: 1.8; }
    .page-content { font-size: 1.15rem; }
    .page-content p { margin-bottom: 1.5rem; }
    .page-content img { max-width: 100%; height: auto; border-radius: 1rem; margin-top: 1rem; margin-bottom: 2rem; }
    .page-content h2, .page-content h3, .page-content h4 { font-weight: 700; color: #1e3c72; margin-top: 2rem; margin-bottom: 1rem; }
</style>
@endpush
