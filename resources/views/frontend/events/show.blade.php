@extends('layouts.frontend')

@push('title')
{{ $event->title }} - {{ __('Agenda') }} -
@endpush

@section('content')
<div class="page-header-premium py-5 text-white position-relative overflow-hidden">
    <div class="page-header-pattern"></div>
    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-up">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 text-white-50">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-white-50">{{ __('Agenda') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ \Illuminate\Support\Str::limit($event->title, 30) }}</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-0">{{ $event->title }}</h1>
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
        <div class="row g-5">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <img src="{{ $event->featured_image_url }}" class="img-fluid w-100" alt="{{ $event->title }}" style="max-height: 500px; object-fit: cover;">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <div class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                <i class="fas fa-tag me-1"></i> {{ $event->category ?: __('Kegiatan') }}
                            </div>
                            @if($event->is_free)
                            <div class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                <i class="fas fa-ticket-alt me-1"></i> {{ __('Gratis') }}
                            </div>
                            @else
                            <div class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">
                                <i class="fas fa-ticket-alt me-1"></i> Rp {{ number_format($event->price, 0, ',', '.') }}
                            </div>
                            @endif
                        </div>

                        <div class="text-dark leading-relaxed mb-5">
                            @safeHtml($event->description)
                        </div>

                        @if($event->online_url)
                        <div class="alert alert-info border-0 rounded-4 p-4 d-flex align-items-center shadow-sm">
                            <i class="fas fa-video fa-2x me-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('Tautan Kegiatan Online') }}</h6>
                                <a href="{{ $event->online_url }}" target="_blank" class="text-decoration-none fw-bold">{{ $event->online_url }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-left">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Event Info Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-primary text-white p-4 rounded-top-4">
                            <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>{{ __('Detail Agenda') }}</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex mb-4">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="fas fa-calendar-day fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">{{ __('Waktu & Tanggal') }}</small>
                                    <span class="fw-bold text-dark">{{ $event->start_date->format('d M Y') }}</span>
                                    <small class="d-block text-secondary">{{ $event->start_date->format('H:i') }} - {{ $event->end_date ? $event->end_date->format('H:i') : __('Selesai') }}</small>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="fas fa-map-marked-alt fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">{{ __('Lokasi') }}</small>
                                    <span class="fw-bold text-dark">{{ $event->location }}</span>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="fas fa-user-tie fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">{{ __('Penyelenggara') }}</small>
                                    <span class="fw-bold text-dark">{{ $event->organizer ?: __('Program Studi') }}</span>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="bg-light p-3 rounded-4 me-3 text-primary">
                                    <i class="fas fa-phone-alt fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">{{ __('Kontak Person') }}</small>
                                    <span class="fw-bold text-dark">{{ $event->contact_person ?: '-' }}</span>
                                </div>
                            </div>

                            <hr>

                            <div class="text-center">
                                @if($event->registration_deadline && $event->registration_deadline->isPast())
                                <button class="btn btn-secondary rounded-pill w-100 py-3 disabled" disabled>{{ __('Pendaftaran Ditutup') }}</button>
                                @else
                                <a href="#" class="btn btn-primary rounded-pill w-100 py-3 shadow-sm fw-bold">{{ __('Daftar Sekarang') }}</a>
                                <small class="text-muted mt-2 d-block">{{ __('Batas pendaftaran:') }} {{ $event->registration_deadline ? $event->registration_deadline->format('d M Y') : '-' }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Related Events -->
                    @if($relatedEvents->count() > 0)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">{{ __('Agenda Lainnya') }}</h5>
                            @foreach($relatedEvents as $related)
                            <div class="d-flex mb-3 align-items-center">
                                <img src="{{ $related->featured_image_url }}" alt="" class="rounded-3 me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-1 small"><a href="{{ route('events.show', $related->slug) }}" class="text-dark text-decoration-none">{{ $related->title }}</a></h6>
                                    <small class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $related->start_date->format('d M Y') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .rotate-n-15 { transform: rotate(-15deg); }
    .bg-primary-subtle { background-color: rgba(12, 121, 14, 0.1); }
    .border-primary-subtle { border-color: rgba(12, 121, 14, 0.2) !important; }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
    .border-success-subtle { border-color: rgba(25, 135, 84, 0.2) !important; }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
    .border-warning-subtle { border-color: rgba(255, 193, 7, 0.2) !important; }
    .leading-relaxed { line-height: 1.8; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-2px); }
</style>
@endpush
