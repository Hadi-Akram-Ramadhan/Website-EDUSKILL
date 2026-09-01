@extends('errors.layout')

@section('title', '500 - Kendala Server')

@section('content')
    <div class="code-badge badge-red">
        <span>ERROR 500</span>
    </div>

    <div class="error-icon-box icon-red">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
    </div>

    <h1 class="error-title">Terjadi Kendala Internal</h1>
    <p class="error-desc">
        Sistem sedang mengalami kendala sementara saat memproses permintaanmu. Jangan khawatir, tim pengembang sedang menanganinya.
    </p>

    <div class="actions-row">
        <a href="{{ route('landing') }}" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Kembali ke Beranda</span>
        </a>
        <button onclick="window.location.reload()" class="btn-3d btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
            <span>Coba Lagi</span>
        </button>
    </div>
@endsection
