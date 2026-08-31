<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Resmi: {{ $certificate->cert_code }} - EduSkill</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,600;1,700&family=Fira+Code:wght@500;700&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- html2pdf.js for High-Quality Native Client-Side A4 Landscape PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-shadow: #1e40af;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --bg-page: #f1f5f9;
            --border-color: #cbd5e1;
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
            flex-direction: column;
            align-items: center;
        }

        /* Top Action Bar (Controls & Buttons) */
        .top-action-bar {
            width: 100%;
            background: #ffffff;
            border-bottom: 2px solid var(--border-color);
            padding: 14px 24px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .action-bar-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 13px;
            text-decoration: none;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            user-select: none;
        }

        .btn-3d:active {
            transform: translateY(3px);
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }
        .btn-blue:active {
            box-shadow: 0 0 0 var(--primary-blue-shadow);
        }

        .btn-green {
            background: var(--accent-green);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--accent-green-shadow);
        }
        .btn-green:active {
            box-shadow: 0 0 0 var(--accent-green-shadow);
        }

        .btn-outline {
            background: #ffffff;
            color: #334155;
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-outline:active {
            box-shadow: 0 0 0 #cbd5e1;
        }

        /* Certificate Stage & Non-Responsive Landscape Canvas */
        .cert-stage-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 16px 64px 16px;
            overflow-x: auto; /* Allows smooth horizontal swipe on small screens without breaking the certificate */
        }

        .mobile-hint {
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            background: #e2e8f0;
            padding: 6px 14px;
            border-radius: 9999px;
            margin-bottom: 16px;
        }

        /* FIXED NON-RESPONSIVE A4 LANDSCAPE CERTIFICATE CANVAS */
        .cert-fixed-canvas {
            width: 980px;
            min-width: 980px;
            max-width: 980px;
            height: 690px;
            min-height: 690px;
            max-height: 690px;
            background: #ffffff;
            position: relative;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
            border-radius: 6px;
            box-sizing: border-box;
            padding: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Double Border Ornaments */
        .cert-outer-border {
            width: 100%;
            height: 100%;
            border: 4px solid #1e3a8a; /* Deep Royal Navy */
            position: relative;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cert-inner-border {
            width: 100%;
            height: 100%;
            border: 1.5px solid #d97706; /* Polished Gold */
            padding: 28px 36px;
            box-sizing: border-box;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: radial-gradient(circle at center, #ffffff 60%, #fcfdfd 100%);
        }

        /* Ornate Corner Elements */
        .corner-ornament {
            position: absolute;
            width: 32px;
            height: 32px;
            color: #d97706;
        }
        .corner-tl { top: -2px; left: -2px; }
        .corner-tr { top: -2px; right: -2px; }
        .corner-bl { bottom: -2px; left: -2px; }
        .corner-br { bottom: -2px; right: -2px; }

        .cert-heading-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid #e2e8f0;
            padding-bottom: 14px;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cert-main-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #0f172a;
            text-align: center;
            text-transform: uppercase;
        }

        .cert-main-subtitle {
            text-align: center;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .recipient-section {
            text-align: center;
            margin: 12px 0;
        }

        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 700;
            font-style: italic;
            color: #1e3a8a;
            display: inline-block;
            padding: 4px 32px 8px 32px;
            border-bottom: 2px solid #d97706;
            margin: 10px 0 6px 0;
            letter-spacing: 0.5px;
        }

        .cert-footer-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr 1fr;
            gap: 16px;
            align-items: flex-end;
            padding-top: 14px;
            border-top: 1.5px solid #e2e8f0;
        }

        .signature-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .signature-name {
            font-family: 'Great Vibes', 'Playfair Display', cursive;
            font-size: 34px;
            color: #1e3a8a;
            line-height: 1;
            margin-bottom: 4px;
            padding-left: 6px;
        }

        .signature-line {
            width: 170px;
            border-bottom: 2px solid #0f172a;
            margin-bottom: 4px;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* Print Media Styles for 100% Crisp A4 Landscape Printing */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-stage-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
            }
            .cert-fixed-canvas {
                box-shadow: none !important;
                border-radius: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                min-width: 100vw !important;
                max-width: 100vw !important;
                min-height: 100vh !important;
                max-height: 100vh !important;
                padding: 16px !important;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 1024px) {
            .mobile-hint {
                display: inline-flex;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action & Navigation Controls (Hidden in Print / PDF) -->
    <header class="top-action-bar no-print">
        <div class="action-bar-inner">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 900; color: #0f172a;">Sertifikat Digital Terverifikasi</div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">Serial: {{ $certificate->cert_code }}</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button onclick="downloadCertificatePDF()" id="btn-export-pdf" class="btn-3d btn-green" title="Download Sertifikat dalam format PDF A4 Landscape">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Unduh PDF (A4)</span>
                </button>

                <button onclick="window.print()" class="btn-3d btn-outline" title="Cetak langsung menggunakan printer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Cetak</span>
                </button>

                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue" title="Kembali ke platform belajar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>Belajar</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Stage Wrapper with Horizontal Scroll -->
    <main class="cert-stage-wrapper">
        
        <!-- Mobile swipe hint -->
        <div class="mobile-hint no-print">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            <span>Geser horizontal untuk melihat bentuk sertifikat secara utuh</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>

        <!-- FIXED NON-RESPONSIVE A4 LANDSCAPE CERTIFICATE -->
        <div class="cert-fixed-canvas" id="certificate-render-canvas">
            
            <div class="cert-outer-border">
                <div class="cert-inner-border">
                    
                    <!-- 4 Ornate Vector Corners -->
                    <div class="corner-ornament corner-tl">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h10v3H3v7H0V0zm6 6h4v2H8v2H6V6z"></path></svg>
                    </div>
                    <div class="corner-ornament corner-tr">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M24 0h-10v3h7v7h3V0zm-6 6h-4v2h2v2h2V6z"></path></svg>
                    </div>
                    <div class="corner-ornament corner-bl">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M0 24h10v-3H3v-7H0v10zm6-6h4v-2H8v-2H6v4z"></path></svg>
                    </div>
                    <div class="corner-ornament corner-br">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M24 24h-10v-3h7v-7h3v10zm-6-6h-4v-2h2v-2h2v4z"></path></svg>
                    </div>

                    <!-- Header Brand & Serial -->
                    <div class="cert-heading-brand">
                        <div class="brand-logo-wrap">
                            <div style="width: 36px; height: 36px; background: #1e3a8a; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fde047;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            </div>
                            <div>
                                <div style="font-size: 16px; font-weight: 900; color: #1e3a8a; letter-spacing: 1px; line-height: 1;">EDUSKILL</div>
                                <div style="font-size: 8px; font-weight: 800; color: #d97706; letter-spacing: 1.5px; text-transform: uppercase;">Learning Platform</div>
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Nomor Sertifikat Resmi</div>
                            <div class="code-font" style="font-size: 13px; font-weight: 700; color: #1e3a8a;">{{ $certificate->cert_code }}</div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 6px; background: #ecfdf5; border: 1.5px solid #a7f3d0; padding: 4px 12px; border-radius: 9999px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span style="font-size: 10px; font-weight: 900; color: #065f46; text-transform: uppercase; letter-spacing: 0.5px;">Resmi & Terverifikasi</span>
                        </div>
                    </div>

                    <!-- Title & Certificate Body -->
                    <div style="text-align: center; margin-top: 14px;">
                        <div class="cert-main-title">SERTIFIKAT RESMI KELULUSAN</div>
                        <div class="cert-main-subtitle">CERTIFICATE OF COMPLETION & EXCELLENCE</div>
                    </div>

                    <div class="recipient-section">
                        <div style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">Diberikan dengan bangga kepada:</div>
                        <div class="recipient-name">{{ $certificate->recipient_name }}</div>
                        <div style="font-size: 13px; color: #475569; max-width: 680px; margin: 4px auto 0 auto; line-height: 1.5;">
                            Telah berhasil menuntaskan seluruh modul kurikulum, praktik kode, mini project, dan evaluasi pemahaman pada kursus:
                        </div>
                        <div style="font-size: 20px; font-weight: 900; color: #1e3a8a; margin-top: 6px; letter-spacing: 0.5px;">
                            {{ $certificate->course_title }}
                        </div>
                    </div>

                    <!-- Footer 3-Column: Signature, Gold Medallion & Grade, QR Code Verification -->
                    <div class="cert-footer-grid">
                        
                        <!-- Left: Instructor Signature -->
                        <div class="signature-box">
                            <div class="signature-name">{{ $certificate->mentor_name }}</div>
                            <div class="signature-line"></div>
                            <div style="font-size: 12px; font-weight: 900; color: #0f172a;">{{ $certificate->mentor_name }}</div>
                            <div style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Lead Mentor & Instruktur</div>
                        </div>

                        <!-- Middle: Gold Seal & Score Badge -->
                        <div style="text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <!-- Medallion Ribbon Vector -->
                            <div style="width: 58px; height: 58px; background: radial-gradient(circle, #fde047 30%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.35); border: 2px solid #ffffff; margin-bottom: 6px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                            
                            <div style="font-size: 13px; font-weight: 900; color: #0f172a;">
                                Rata-rata Skor: <span style="color: {{ $certificate->grade_info['badge_color'] }};">{{ number_format($certificate->score_average, 1) }} / 100</span>
                            </div>

                            <div style="margin-top: 3px;">
                                <span style="font-size: 10px; font-weight: 900; background: {{ $certificate->grade_info['badge_bg'] }}; color: {{ $certificate->grade_info['badge_color'] }}; border: 1.5px solid {{ $certificate->grade_info['badge_border'] }}; padding: 2px 10px; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Grade {{ $certificate->grade_info['grade'] }} &bull; {{ $certificate->grade_info['predicate'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Right: QR Code & Verification Data -->
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                            <div style="text-align: right;">
                                <div style="font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase;">Diterbitkan:</div>
                                <div style="font-size: 11px; font-weight: 800; color: #0f172a;">{{ Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}</div>
                                <div style="font-size: 8px; color: #94a3b8; margin-top: 4px; max-width: 120px; word-break: break-all;" class="code-font" title="{{ $certificate->cert_hash }}">
                                    SHA256: {{ substr($certificate->cert_hash, 0, 14) }}...
                                </div>
                            </div>

                            <div style="text-align: center;">
                                <img src="{{ $certificate->qr_code_url }}" alt="QR Code" style="width: 72px; height: 72px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 2px; background: #fff; display: block;">
                                <div style="font-size: 8px; font-weight: 800; color: #64748b; margin-top: 2px; letter-spacing: 0.5px;">VERIFIKASI</div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </main>

    <!-- Client-Side Export PDF Script -->
    <script>
        function downloadCertificatePDF() {
            const element = document.getElementById('certificate-render-canvas');
            const btnExport = document.getElementById('btn-export-pdf');
            
            if (!element) return;

            // Visual feedback
            const originalContent = btnExport.innerHTML;
            btnExport.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="animate-spin"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
                <span>Menyiapkan PDF...</span>
            `;
            btnExport.disabled = true;

            const opt = {
                margin: 0,
                filename: 'Sertifikat_EduSkill_{{ $certificate->cert_code }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2, 
                    useCORS: true,
                    logging: false,
                    scrollY: 0,
                    scrollX: 0
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'a4', 
                    orientation: 'landscape' 
                }
            };

            // Generate PDF
            if (window.html2pdf) {
                html2pdf().set(opt).from(element).save().then(() => {
                    btnExport.innerHTML = originalContent;
                    btnExport.disabled = false;
                }).catch(err => {
                    console.error('PDF Generation Error:', err);
                    btnExport.innerHTML = originalContent;
                    btnExport.disabled = false;
                    window.print();
                });
            } else {
                window.print();
                btnExport.innerHTML = originalContent;
                btnExport.disabled = false;
            }
        }
    </script>
</body>
</html>
