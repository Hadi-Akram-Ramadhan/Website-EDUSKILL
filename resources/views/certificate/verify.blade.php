<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat Resmi - {{ $certificate ? $certificate->cert_code : 'Tidak Ditemukan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.85);
            --border-color: rgba(255, 255, 255, 0.1);
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.25);
            --success: #10b981;
            --success-glow: rgba(16, 185, 129, 0.2);
            --danger: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --gold: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .container {
            width: 100%;
            max-width: 680px;
        }

        .header-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .header-logo .badge-platform {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #10b981, #f59e0b);
        }

        .status-header {
            text-align: center;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 28px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .status-valid {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #34d399;
            box-shadow: 0 0 20px var(--success-glow);
        }

        .status-invalid {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
        }

        .cert-title {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .cert-code {
            font-family: monospace;
            font-size: 15px;
            color: #94a3b8;
            letter-spacing: 1px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        @media (max-width: 540px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .card {
                padding: 24px 20px;
            }
        }

        .info-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px;
            border-radius: 14px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #f8fafc;
            word-break: break-word;
        }

        .info-value.highlight {
            color: #a5b4fc;
        }

        .qr-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 24px;
        }

        .qr-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: white;
            padding: 4px;
        }

        .hash-box {
            font-size: 11px;
            color: #64748b;
            font-family: monospace;
            word-break: break-all;
            margin-top: 6px;
        }

        .footer-note {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-logo">
            <div class="badge-platform">
                <span>⚡</span> Gamified Code Learning Platform
            </div>
        </div>

        <div class="card">
            @if ($isValid && $certificate)
                <div class="status-header">
                    <div class="status-badge status-valid">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        SERTIFIKAT RESMI & TERVERIFIKASI
                    </div>
                    <h1 class="cert-title">{{ $certificate->course_title }}</h1>
                    <div class="cert-code">{{ $certificate->cert_code }}</div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Diberikan Kepada</div>
                        <div class="info-value highlight">{{ $certificate->recipient_name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Kelulusan</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Instruktur / Mentor</div>
                        <div class="info-value">{{ $certificate->mentor_name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Skor Kelulusan</div>
                        <div class="info-value" style="color: #34d399;">{{ number_format($certificate->score_average, 1) }} / 100</div>
                    </div>
                </div>

                <div class="qr-section">
                    <div>
                        <div class="info-label">Security Hash Verification</div>
                        <div class="info-value" style="font-size: 13px; color: #cbd5e1;">Cryptographically Signed</div>
                        <div class="hash-box">{{ $certificate->cert_hash }}</div>
                    </div>
                    @if ($certificate->qr_code_url)
                        <img src="{{ $certificate->qr_code_url }}" alt="QR Verification" class="qr-image">
                    @endif
                </div>
            @else
                <div class="status-header">
                    <div class="status-badge status-invalid">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        SERTIFIKAT TIDAK DITEMUKAN
                    </div>
                    <h1 class="cert-title">Data Tidak Valid</h1>
                    <div class="cert-code">{{ $certCode }}</div>
                </div>
                <p style="text-align: center; color: var(--text-muted); margin-bottom: 20px;">
                    Kode sertifikat yang dimasukkan tidak terdaftar dalam database kami atau telah dicabut.
                </p>
            @endif

            <div class="footer-note">
                Sertifikat ini diterbitkan secara otomatis setelah siswa menyelesaikan seluruh materi, evaluasi modul, dan tantangan kode interaktif.
            </div>
        </div>
    </div>
</body>
</html>
