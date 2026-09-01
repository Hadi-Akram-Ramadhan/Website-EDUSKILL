@extends('errors.layout')

@section('title', '419 - Sesi Kedaluwarsa')

@section('content')
    <div class="code-badge badge-amber">
        <span>ERROR 419</span>
    </div>

    <div class="error-icon-box icon-amber">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
    </div>

    <h1 class="error-title">Sesi Halaman Berakhir</h1>
    <p class="error-desc">
        Halaman telah terbuka terlalu lama atau token keamanan (CSRF) telah kedaluwarsa. Silakan muat ulang atau masuk kembali.
    </p>

    <div class="actions-row">
        <button onclick="window.location.reload()" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
            <span>Muat Ulang Halaman</span>
        </button>
        <a href="{{ route('login') }}" class="btn-3d btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            <span>Masuk Akun</span>
        </a>
    </div>
@endsection
