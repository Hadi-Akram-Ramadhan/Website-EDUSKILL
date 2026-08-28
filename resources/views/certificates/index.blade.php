@php
    $title = 'Sertifikat Resmi - Kodein';
@endphp

<x-app-layout>
    <div style="width: 100%; max-width: 780px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 48px; margin-bottom: 8px;" class="animate-float">🎓</div>
            <h1 style="font-size: 28px; font-weight: 900; letter-spacing: -0.5px;">Sertifikasi Resmi Pemrograman</h1>
            <p style="color: #94a3b8; font-size: 14px; margin-top: 4px;">Selesaikan 100% materi dalam satu kursus untuk menerbitkan sertifikat ber-QR Code valid.</p>
        </div>

        @if (session('error'))
            <div style="background: rgba(239, 68, 68, 0.15); border: 2px solid var(--duo-red); border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #fca5a5;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach ($coursesData as $item)
                <div class="card-3d" style="padding: 24px;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 16px; flex-wrap: wrap;">
                        <div>
                            <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; background: rgba(88, 204, 2, 0.15); color: #86efac; padding: 4px 10px; border-radius: 8px;">
                                {{ $item['course']->category }}
                            </span>
                            <h2 style="font-size: 20px; font-weight: 900; margin-top: 6px;">{{ $item['course']->title }}</h2>
                            <p style="font-size: 13px; color: #94a3b8; margin-top: 4px;">{{ $item['course']->target_audience }} • Instruktur: {{ $item['course']->mentor->name ?? 'Tim Instruktur' }}</p>
                        </div>

                        @if ($item['certificate'])
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; color: #86efac; background: rgba(88, 204, 2, 0.1); border: 1px solid var(--duo-green); padding: 6px 12px; border-radius: 9999px;">
                                <span>✔</span> DITERBITKAN
                            </span>
                        @endif
                    </div>

                    <!-- Progress bar -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 800; margin-bottom: 6px;">
                            <span>Progres Kelulusan Modul</span>
                            <span style="color: {{ $item['is_completed'] ? 'var(--duo-green)' : 'var(--duo-blue)' }};">
                                {{ $item['completed_lessons'] }}/{{ $item['total_lessons'] }} Modul ({{ $item['progress_percentage'] }}%)
                            </span>
                        </div>
                        <div style="height: 12px; background: #131f24; border-radius: 9999px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $item['progress_percentage'] }}%; background: {{ $item['is_completed'] ? 'var(--duo-green)' : 'var(--duo-blue)' }}; border-radius: 9999px;"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                        @if ($item['certificate'])
                            <a href="{{ route('certificate.verify', $item['certificate']->cert_code) }}" class="btn-3d btn-green" target="_blank" style="font-size: 13px; padding: 10px 20px;">
                                LIHAT & CETAK SERTIFIKAT 📜
                            </a>
                        @elseif ($item['is_completed'])
                            <form action="{{ route('certificates.claim', $item['course']->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-3d btn-green" style="font-size: 13px; padding: 10px 20px;">
                                    KLAIM SERTIFIKAT RESMI 🎓
                                </button>
                            </form>
                        @else
                            <a href="{{ route('learn.index') }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 20px;">
                                LANJUTKAN BELAJAR 🚀
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
