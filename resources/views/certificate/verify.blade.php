<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat: {{ $certificate->cert_code }} - EduSkill</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Fira+Code:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-shadow: #1e40af;
            --accent-green: #10b981;
            --bg-page: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .cert-card {
            width: 100%;
            max-width: 820px;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 28px;
            padding: 48px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .cert-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa);
        }

        .cert-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #0f172a;
            text-align: center;
            margin-bottom: 8px;
        }

        .cert-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 32px;
        }

        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-style: italic;
            font-weight: 600;
            color: var(--primary-blue);
            text-align: center;
            margin: 16px 0;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
            display: inline-block;
        }

        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 12px 24px;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #fff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>
<body>
    <div class="cert-card">
        
        <!-- Status Verified Pill -->
        <div style="text-align: center; margin-bottom: 24px;">
            <span style="display: inline-flex; align-items: center; gap: 8px; background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Sertifikat Digital Terverifikasi
            </span>
        </div>

        <div class="cert-title">SERTIFIKAT RESMI KELULUSAN</div>
        <div class="cert-subtitle">EDUSKILL LEARNING PLATFORM</div>

        <div style="text-align: center; margin: 32px 0;">
            <p style="color: var(--text-muted); font-size: 15px;">Diberikan secara resmi kepada:</p>
            <div class="recipient-name">{{ $certificate->recipient_name }}</div>
            <p style="color: var(--text-muted); font-size: 15px; max-width: 580px; margin: 16px auto 0 auto; line-height: 1.6;">
                Telah berhasil menyelesaikan seluruh materi kurikulum dan ujian evaluasi interaktif pada kursus:
            </p>
            <div style="font-size: 20px; font-weight: 900; color: #0f172a; margin-top: 8px;">
                {{ $certificate->course_title }}
            </div>
        </div>

        <!-- Certificate Metadata Grid -->
        <div style="display: grid; grid-template-columns: 1fr 120px; gap: 24px; align-items: center; border-top: 2px dashed #e2e8f0; padding-top: 28px; margin-top: 32px;">
            <div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 13px;">
                    <div>
                        <span style="color: var(--text-muted); font-size: 12px;">Nomor Sertifikat:</span>
                        <div class="code-font" style="font-weight: 800; color: var(--primary-blue);">{{ $certificate->cert_code }}</div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 12px;">Tanggal Terbit:</span>
                        <div style="font-weight: 800;">{{ Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 12px;">Instruktur / Mentor:</span>
                        <div style="font-weight: 800;">{{ $certificate->mentor_name }}</div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 12px;">Skor Belajar & Predikat:</span>
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px; flex-wrap: wrap;">
                            <span style="font-weight: 900; color: {{ $certificate->grade_info['badge_color'] }}; font-size: 14px;">
                                {{ number_format($certificate->score_average, 1) }} / 100
                            </span>
                            <span style="font-size: 10px; font-weight: 900; background: {{ $certificate->grade_info['badge_bg'] }}; color: {{ $certificate->grade_info['badge_color'] }}; border: 1px solid {{ $certificate->grade_info['badge_border'] }}; padding: 2px 8px; border-radius: 6px;">
                                Grade {{ $certificate->grade_info['grade'] }} &bull; {{ $certificate->grade_info['predicate'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 14px; font-size: 10px; color: #94a3b8; word-break: break-all;">
                    Digital Signature: <span class="code-font">{{ $certificate->cert_hash }}</span>
                </div>
            </div>

            <div style="text-align: center;">
                <img src="{{ $certificate->qr_code_url }}" alt="QR Code" style="width: 100px; height: 100px; border-radius: 12px; border: 2px solid #e2e8f0; padding: 4px; background: #fff;">
                <div style="font-size: 10px; font-weight: 800; color: #64748b; margin-top: 4px;">SCAN VERIFIKASI</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('learn.index') }}" class="btn-3d btn-blue">
                Kembali ke Platform Belajar
            </a>
        </div>
    </div>
</body>
</html>
