@extends('errors.layout')

@section('title', '503 - Pemeliharaan Sistem')

@section('content')
    <div class="code-badge badge-blue">
        <span>ERROR 503</span>
    </div>

    <div class="error-icon-box icon-blue">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
        </svg>
    </div>

    <h1 class="error-title">Sedang Pemeliharaan</h1>
    <p class="error-desc">
        EduSkill sedang melakukan pembaruan sistem dan peningkatan kualitas layanan. Kami akan segera kembali dalam beberapa saat!
    </p>

    <div class="actions-row">
        <button onclick="window.location.reload()" class="btn-3d btn-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
            <span>Periksa Status</span>
        </button>
    </div>
@endsection
