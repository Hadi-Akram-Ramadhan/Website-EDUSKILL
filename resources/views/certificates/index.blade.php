@php
    $title = 'Sertifikat Resmi - Kodein';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 860px; margin: 0 auto; width: 100%;">
        
        <!-- Header Banner (Blue Theme) -->
        <div style="text-align: center; margin-bottom: 36px;">
            <div style="width: 64px; height: 64px; margin: 0 auto 16px auto; background: var(--primary-blue-light); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); box-shadow: 0 4px 0 #bfdbfe;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
            </div>
            <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Sertifikasi Resmi Kodein</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Selesaikan seluruh modul pada kursus untuk mendapatkan sertifikat digital terverifikasi.</p>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 16px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 18px; padding: 16px 20px; margin-bottom: 24px; font-weight: 700; color: #991b1b; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Courses Progress & Claim List -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach ($coursesData as $card)
                <div class="card-3d" style="padding: 28px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 280px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--primary-blue); background: var(--primary-blue-light); padding: 4px 10px; border-radius: 8px; border: 1px solid #bfdbfe;">
                                {{ $card['course']->category }}
                            </span>
                            <span style="font-size: 12px; color: #64748b; font-weight: 700;">
                                Mentor: {{ $card['course']->mentor->name ?? 'Tim Kodein' }}
                            </span>
                        </div>

                        <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                            {{ $card['course']->title }}
                        </h3>

                        <!-- Progress Bar -->
                        <div style="margin-top: 14px;">
                            <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 800; margin-bottom: 6px;">
                                <span style="color: #64748b;">Progress Kelulusan ({{ $card['completed_lessons'] }}/{{ $card['total_lessons'] }} Modul)</span>
                                <span style="color: {{ $card['progress_percentage'] === 100 ? '#059669' : 'var(--primary-blue)' }};">{{ $card['progress_percentage'] }}%</span>
                            </div>
                            <div style="height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $card['progress_percentage'] }}%; background: {{ $card['progress_percentage'] === 100 ? '#10b981' : 'var(--primary-blue)' }}; border-radius: 9999px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button / Certificate Status -->
                    <div>
                        @if ($card['certificate'])
                            <div style="text-align: right;">
                                <a href="{{ route('certificate.verify', $card['certificate']->cert_code) }}" target="_blank" class="btn-3d btn-green" style="font-size: 13px; padding: 12px 20px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h20"></path><path d="M12 2v20"></path></svg>
                                    Lihat Sertifikat ({{ $card['certificate']->cert_code }})
                                </a>
                                <div style="font-size: 11px; color: #059669; font-weight: 700; margin-top: 6px;">
                                    Terbit: {{ Carbon\Carbon::parse($card['certificate']->issue_date)->format('d M Y') }}
                                </div>
                            </div>
                        @elseif ($card['is_completed'])
                            <form action="{{ route('certificates.claim', $card['course']->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-3d btn-blue" style="font-size: 13px; padding: 14px 24px;">
                                    Klaim Sertifikat Resmi
                                </button>
                            </form>
                        @else
                            <div style="display: flex; align-items: center; gap: 8px; color: #94a3b8; font-size: 13px; font-weight: 800;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                Selesaikan Semua Modul
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
