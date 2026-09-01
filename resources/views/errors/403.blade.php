@extends('errors.layout')

@section('title', '403 - Akses Ditolak')

@section('content')
    <div class="code-badge badge-amber">
        <span>ERROR 403</span>
    </div>

    <div class="error-icon-box icon-amber">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
        </svg>
    </div>

    <h1 class="error-title">Akses Dibatasi</h1>
    <p class="error-desc">
        Kamu tidak memiliki izin atau hak akses (role) untuk membuka menu ini. Pastikan kamu masuk dengan akun yang sesuai.
    </p>

    <div class="actions-row">
        <a href="{{ route('landing') }}" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('login') }}" class="btn-3d btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            <span>Ganti Akun</span>
        </a>
    </div>
@endsection
