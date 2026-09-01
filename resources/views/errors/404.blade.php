@extends('errors.layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="code-badge badge-blue">
        <span>ERROR 404</span>
    </div>

    <div class="error-icon-box icon-blue">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m4.93 4.93 14.14 14.14"></path>
        </svg>
    </div>

    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
    <p class="error-desc">
        Halaman atau modul yang kamu tuju sepertinya sudah dipindahkan, dihapus, atau tautan yang kamu masukkan kurang tepat.
    </p>

    <div class="actions-row">
        <a href="{{ route('landing') }}" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('learn.index') }}" class="btn-3d btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
            <span>Roadmap Belajar</span>
        </a>
    </div>
@endsection
