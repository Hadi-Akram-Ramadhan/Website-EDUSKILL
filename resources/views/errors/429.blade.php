@extends('errors.layout')

@section('title', '429 - Terlalu Banyak Permintaan')

@section('content')
    <div class="code-badge badge-amber">
        <span>ERROR 429</span>
    </div>

    <div class="error-icon-box icon-amber">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
    </div>

    <h1 class="error-title">Terlalu Banyak Permintaan</h1>
    <p class="error-desc">
        Kamu telah melakukan terlalu banyak permintaan dalam waktu singkat. Mohon istirahat sejenak dan coba kembali beberapa detik lagi.
    </p>

    <div class="actions-row">
        <a href="{{ route('landing') }}" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Kembali ke Beranda</span>
        </a>
    </div>
@endsection
