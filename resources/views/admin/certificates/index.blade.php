@php
    $title = 'Rekap Sertifikat Resmi - Super Admin';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 1060px; margin: 0 auto; width: 100%;">
        
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
            <div>
                <a href="{{ route('admin.dashboard') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Dashboard
                </a>
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Rekap Sertifikat Diterbitkan</h1>
                <p style="color: #64748b; font-size: 14px;">Audit dan pantau seluruh sertifikat kelulusan resmi dengan verifikasi QR &amp; SHA-256.</p>
            </div>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="card-3d" style="padding: 18px 20px; margin-bottom: 24px;">
            <form action="{{ route('admin.certificates.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, kode sertifikat, atau kursus..." style="padding: 10px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; min-width: 280px; outline: none; flex: 1;">
                <button type="submit" class="btn-3d btn-blue" style="padding: 10px 18px; font-size: 13px;">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.certificates.index') }}" class="btn-3d btn-outline" style="padding: 10px 14px; font-size: 13px;">Reset</a>
                @endif
            </form>
        </div>

        <!-- Certificate Table -->
        <div class="card-3d" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">
                            <th style="padding: 16px 20px;">Penerima &amp; Kursus</th>
                            <th style="padding: 16px 20px;">Kode Sertifikat</th>
                            <th style="padding: 16px 20px;">Nilai &amp; Tanggal Terbit</th>
                            <th style="padding: 16px 20px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certificates as $cert)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 20px;">
                                    <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $cert->recipient_name }}</div>
                                    <div style="font-size: 12px; color: #64748b;">{{ $cert->course_title }}</div>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <span class="code-font" style="font-size: 12px; font-weight: 700; color: var(--primary-blue); background: #eff6ff; padding: 4px 8px; border-radius: 6px;">
                                        {{ $cert->cert_code }}
                                    </span>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <div style="font-size: 13px; font-weight: 800; color: #059669;">Nilai: {{ $cert->score_average }}/100</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ Carbon\Carbon::parse($cert->issue_date)->format('d M Y') }}</div>
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <a href="{{ route('certificate.verify', $cert->cert_code) }}" target="_blank" class="btn-3d btn-outline" style="padding: 8px 12px; font-size: 11px; border-radius: 10px;">
                                            Buka QR &amp; Cek
                                        </a>
                                        <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Cabut dan hapus sertifikat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-red" style="padding: 8px 12px; font-size: 11px; border-radius: 10px;">
                                                Cabut
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 36px; color: #64748b; font-size: 14px;">
                                    Belum ada sertifikat yang diterbitkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($certificates->hasPages())
                <div style="padding: 16px 20px; border-top: 2px solid #e2e8f0; background: #f8fafc;">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
