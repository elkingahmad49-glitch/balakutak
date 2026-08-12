@extends('layouts.frontend')

@push('title'){{ $announcement->title }} - @endpush

@section('content')
<div class="container py-5 mt-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('menu.announcement') }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex flex-wrap gap-2 mb-4 align-items-center">
                        <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-bullhorn me-1"></i> {{ __('menu.announcement') }}</span>
                        
                        @if($announcement->priority === 'urgent')
                            <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i> Mendesak</span>
                        @elseif($announcement->priority === 'high')
                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle me-1"></i> Penting</span>
                        @endif
                        
                        <span class="text-muted ms-auto fs-6"><i class="far fa-calendar-alt me-1"></i> {{ $announcement->created_at->isoFormat('D MMMM YYYY') }}</span>
                    </div>

                    <h1 class="fw-bold mb-4" style="line-height: 1.4;">{{ $announcement->title }}</h1>
                    
                    <hr class="mb-4">

                    <div class="article-content fs-5" style="line-height: 1.8;">
                        @safeHtml($announcement->content)
                    </div>

                    @if($announcement->attachment)
                    <div class="mt-5 p-4 bg-light rounded-4 border">
                        <h5 class="fw-bold mb-3"><i class="fas fa-paperclip me-2 text-primary"></i> Lampiran File</h5>
                        <p class="text-muted mb-3">Terdapat file/dokumen yang dilampirkan pada pengumuman ini. Silakan unduh melalui tombol di bawah.</p>
                        <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-download me-2"></i> Unduh Lampiran
                        </a>
                    </div>
                    @endif

                </div>
                <div class="card-footer bg-light p-4 text-center border-0">
                    <a href="{{ route('home') }}" class="btn btn-secondary rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
