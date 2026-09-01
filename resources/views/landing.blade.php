<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>EduSkill - Platform Belajar Pemrograman Interaktif SMP &amp; SMA</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- GSAP & Canvas Confetti Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --primary-blue-light: #eff6ff;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --accent-green-bg: #ecfdf5;
            --accent-orange: #f59e0b;
            --accent-orange-shadow: #d97706;
            --accent-red: #ef4444;
            --accent-purple: #8b5cf6;
            --bg-page: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            background-color: var(--bg-page);
            color: var(--text-main);
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* 3D Chunky Buttons */
        .btn-3d {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 14px 28px;
            font-size: 14px;
            text-decoration: none;
            user-select: none;
            transition: transform 0.1s ease, filter 0.15s ease, box-shadow 0.1s ease;
        }

        .btn-3d:active {
            transform: translateY(4px) !important;
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }
        .btn-blue:hover {
            background: var(--primary-blue-hover);
        }
        .btn-blue:active {
            box-shadow: 0 0 0 var(--primary-blue-shadow);
        }

        .btn-outline {
            background: #ffffff;
            color: var(--primary-blue);
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-outline:active {
            box-shadow: 0 0 0 #cbd5e1;
        }

        .btn-white {
            background: #ffffff;
            color: var(--primary-blue);
            box-shadow: 0 4px 0 #bfdbfe;
        }
        .btn-white:active {
            box-shadow: 0 0 0 #bfdbfe;
        }

        /* Full Width Header Container (Unified Background) */
        .navbar-wrapper {
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* Dynamic Hero Wrapper & Ambient Glow Mesh */
        .hero-wrapper {
            position: relative;
            padding-top: clamp(28px, 4vw, 48px);
            padding-bottom: clamp(36px, 5vw, 56px);
            background-color: #f8fafc;
            overflow: hidden;
        }

        /* Ambient Glow Mesh Gradient Orbs */
        .ambient-glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(75px);
            pointer-events: none;
            z-index: 1;
            opacity: 0.5;
            animation: pulseAmbient 9s ease-in-out infinite alternate;
        }

        .orb-blue {
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: min(650px, 90vw);
            height: 420px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.22) 0%, rgba(37, 99, 235, 0) 70%);
        }

        .orb-emerald {
            top: 22%;
            left: -8%;
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.16) 0%, rgba(16, 185, 129, 0) 70%);
            animation-duration: 11s;
        }

        .orb-purple {
            top: 28%;
            right: -8%;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.18) 0%, rgba(139, 92, 246, 0) 70%);
            animation-duration: 10s;
        }

        .orb-amber {
            bottom: 4%;
            left: 24%;
            width: 440px;
            height: 380px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.13) 0%, rgba(245, 158, 11, 0) 70%);
            animation-duration: 12s;
        }

        @keyframes pulseAmbient {
            0% { transform: scale(1) translateY(0); opacity: 0.45; }
            50% { transform: scale(1.18) translateY(-25px); opacity: 0.75; }
            100% { transform: scale(1) translateY(0); opacity: 0.45; }
        }

        /* Modern Blueprint Matrix Dot-Grid Background */
        .hero-matrix-grid {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(rgba(37, 99, 235, 0.2) 1.5px, transparent 1.5px),
                linear-gradient(to right, rgba(203, 213, 225, 0.45) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(203, 213, 225, 0.45) 1px, transparent 1px);
            background-size: 32px 32px, 64px 64px, 64px 64px;
            background-position: center top;
            mask-image: radial-gradient(ellipse 80% 75% at 50% 35%, #000 35%, transparent 95%);
            -webkit-mask-image: radial-gradient(ellipse 80% 75% at 50% 35%, #000 35%, transparent 95%);
            pointer-events: none;
            z-index: 2;
        }

        /* Floating Code Tokens - only visible on wide screens to prevent clashing on laptops */
        .bg-code-token {
            display: none;
            position: absolute;
            z-index: 3;
            pointer-events: none;
            user-select: none;
            opacity: 0.55;
            transition: transform 0.3s ease;
        }

        @media (min-width: 1480px) {
            .bg-code-token {
                display: block;
            }
        }

        .token-glass-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1.5px solid rgba(191, 219, 254, 0.9);
            box-shadow: 0 10px 20px -4px rgba(37, 99, 235, 0.1), 0 3px 0 #bfdbfe;
            font-family: 'Fira Code', monospace;
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
        }

        .token-symbol {
            font-family: 'Fira Code', monospace;
            font-size: 26px;
            font-weight: 900;
            color: #3b82f6;
            opacity: 0.3;
            letter-spacing: 2px;
            text-shadow: 0 0 16px rgba(59, 130, 246, 0.4);
        }

        /* Floating Keyframes */
        @keyframes floatToken1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-10px, -20px) rotate(4deg); }
        }
        @keyframes floatToken2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(12px, -24px) rotate(-5deg); }
        }
        @keyframes floatToken3 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-8px, -16px) rotate(3deg); }
        }
        @keyframes floatToken4 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(14px, -18px) rotate(-4deg); }
        }

        .anim-token-1 { animation: floatToken1 6s ease-in-out infinite; }
        .anim-token-2 { animation: floatToken2 7.5s ease-in-out infinite 0.8s; }
        .anim-token-3 { animation: floatToken3 8.5s ease-in-out infinite 1.5s; }
        .anim-token-4 { animation: floatToken4 7s ease-in-out infinite 2s; }

        .hero-container {
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
            padding: 0 clamp(16px, 3vw, 24px);
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            color: var(--primary-blue);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: clamp(14px, 2vw, 20px);
        }

        .hero-title {
            font-size: clamp(28px, 4.2vw, 48px);
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: -1px;
            color: #0f172a;
            max-width: 820px;
            margin: 0 auto 16px auto;
        }

        .hero-title span {
            color: var(--primary-blue);
            position: relative;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: clamp(14px, 1.5vw, 17px);
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 640px;
            margin: 0 auto clamp(20px, 3vw, 32px) auto;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: clamp(24px, 3.5vw, 36px);
        }

        /* Side Floating Gamified Badges - ONLY shown on ultra-wide screens to prevent laptop layout collision */
        .side-float-container {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 8;
            overflow: hidden;
        }

        @media (min-width: 1560px) {
            .side-float-container {
                display: block;
            }
        }

        .float-item {
            position: absolute;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 10px 14px;
            box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.08), 0 4px 0 #cbd5e1;
            display: flex;
            align-items: center;
            gap: 10px;
            pointer-events: auto;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .float-item:hover {
            transform: scale(1.08) rotate(2deg) !important;
            box-shadow: 0 16px 30px -5px rgba(37, 99, 235, 0.2), 0 4px 0 #bfdbfe;
            border-color: #93c5fd;
        }

        .float-item:active {
            transform: scale(0.95) !important;
        }

        /* Floating Animation Keyframes */
        @keyframes floatSide1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(3deg); }
        }
        @keyframes floatSide2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(-4deg); }
        }
        @keyframes floatSide3 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(2deg); }
        }

        /* Left Side Items (Far Gutter) */
        .float-left-1 {
            top: 18%;
            left: max(20px, calc((100vw - 1240px) / 4));
            animation: floatSide1 4s ease-in-out infinite;
        }
        .float-left-2 {
            top: 48%;
            left: max(16px, calc((100vw - 1260px) / 4));
            animation: floatSide2 3.6s ease-in-out infinite 0.5s;
        }
        .float-left-3 {
            top: 76%;
            left: max(24px, calc((100vw - 1220px) / 4));
            animation: floatSide3 4.2s ease-in-out infinite 1s;
        }

        /* Right Side Items (Far Gutter) */
        .float-right-1 {
            top: 16%;
            right: max(20px, calc((100vw - 1240px) / 4));
            animation: floatSide2 3.8s ease-in-out infinite 0.3s;
        }
        .float-right-2 {
            top: 46%;
            right: max(16px, calc((100vw - 1260px) / 4));
            animation: floatSide1 4.4s ease-in-out infinite 0.8s;
        }
        .float-right-3 {
            top: 74%;
            right: max(24px, calc((100vw - 1220px) / 4));
            animation: floatSide3 3.9s ease-in-out infinite 1.2s;
        }

        /* Simulator Card */
        .simulator-box {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 28px;
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.12), 0 6px 0 #cbd5e1;
            overflow: hidden;
            text-align: left;
            position: relative;
            z-index: 20;
        }

        .simulator-top-bar {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .simulator-dots {
            display: flex;
            gap: 6px;
        }
        .dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        /* Integrated HUD Row Inside Simulator Header */
        .hud-status-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .hud-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            border: 1.5px solid transparent;
        }

        .hud-pill.heart {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .hud-pill.gems {
            background: #eff6ff;
            color: var(--primary-blue);
            border-color: #bfdbfe;
        }

        .hud-pill.streak {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
        }

        .simulator-body {
            padding: 24px;
        }

        /* Interactive Quiz Chip Choice Buttons */
        .quiz-chip {
            padding: 10px 18px;
            border-radius: 14px;
            background: #f8fafc;
            border: 2px solid #cbd5e1;
            box-shadow: 0 3px 0 #cbd5e1;
            font-family: 'Fira Code', monospace;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
        }

        .quiz-chip:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .quiz-chip:active {
            transform: translateY(2px);
            box-shadow: 0 0 0 #cbd5e1;
        }

        .quiz-chip.selected-correct {
            background: #ecfdf5 !important;
            border-color: #10b981 !important;
            box-shadow: 0 3px 0 #059669 !important;
            color: #065f46 !important;
        }

        .quiz-chip.selected-wrong {
            background: #fef2f2 !important;
            border-color: #ef4444 !important;
            box-shadow: 0 3px 0 #b91c1c !important;
            color: #991b1b !important;
        }

        /* Wave Curve 1: Seamless Bridge into Languages Section */
        .wave-curve-1 {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            background: #f8fafc;
        }

        .wave-curve-1 svg {
            position: relative;
            display: block;
            width: 100%;
            height: 90px;
        }

        /* Section 2: Programming Languages Catalog */
        .languages-section {
            background: radial-gradient(circle at 80% 20%, #2563eb 0%, #1d4ed8 60%, #1e40af 100%);
            color: #ffffff;
            padding: 20px 24px 80px 24px;
            position: relative;
            z-index: 10;
        }

        .languages-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
            pointer-events: none;
            opacity: 0.7;
        }

        .section-header-white {
            text-align: center;
            max-width: 740px;
            margin: 0 auto 40px auto;
            position: relative;
            z-index: 2;
        }

        .section-header-white .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #ffffff;
            padding: 5px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .section-header-white h2 {
            font-size: 34px;
            font-weight: 900;
            letter-spacing: -0.8px;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .section-header-white p {
            font-size: 15px;
            color: #bfdbfe;
            line-height: 1.5;
        }

        .languages-grid {
            max-width: 1140px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        .lang-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 24px;
            color: var(--text-main);
            box-shadow: 0 10px 0 rgba(0, 0, 0, 0.15), 0 15px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .lang-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 0 rgba(0, 0, 0, 0.2), 0 20px 30px rgba(0, 0, 0, 0.15);
        }

        .lang-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .lang-icon-box {
            width: 52px;
            height: 52px;
            min-width: 52px;
            min-height: 52px;
            flex-shrink: 0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .lang-pill-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin: 12px 0 18px 0;
        }

        .lang-pill-tag {
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #475569;
        }

        /* Wave Curve 2: Transition from Blue into White */
        .wave-curve-2 {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            background: #1d4ed8;
        }

        .wave-curve-2 svg {
            position: relative;
            display: block;
            width: 100%;
            height: 90px;
        }

        /* Section 3: Gamified Features */
        .features-section {
            background: radial-gradient(circle at 50% 10%, #f0f7ff 0%, #ffffff 80%);
            padding: 36px 24px 80px 24px;
            position: relative;
            z-index: 20;
        }

        .features-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(37, 99, 235, 0.07) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
            pointer-events: none;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 30%, #000 30%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 30%, #000 30%, transparent 100%);
        }

        .section-header-dark {
            text-align: center;
            max-width: 740px;
            margin: 0 auto 44px auto;
            position: relative;
            z-index: 2;
        }

        .section-header-dark .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-blue-light);
            border: 1.5px solid #bfdbfe;
            color: var(--primary-blue);
            padding: 5px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .section-header-dark h2 {
            font-size: 34px;
            font-weight: 900;
            letter-spacing: -0.8px;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .section-header-dark p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .features-grid {
            max-width: 1140px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 24px;
            padding: 26px 20px;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #bfdbfe;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.12), 0 4px 0 #bfdbfe;
        }

        /* Wave Curve 3: Transition into Light Blue Steps & FAQ */
        .wave-curve-3 {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            background: #ffffff;
        }

        .wave-curve-3 svg {
            position: relative;
            display: block;
            width: 100%;
            height: 80px;
        }

        /* Section 4: 3-Step Journey & FAQ */
        .steps-faq-section {
            background: #f0f7ff;
            padding: 30px 24px 80px 24px;
            position: relative;
        }

        .steps-grid {
            max-width: 1080px;
            margin: 0 auto 70px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .step-box {
            background: #ffffff;
            border: 2px solid #dbeafe;
            border-radius: 24px;
            padding: 28px 20px;
            text-align: center;
            box-shadow: 0 4px 0 #bfdbfe;
        }

        .step-number {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--primary-blue);
            color: #ffffff;
            font-size: 18px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }

        /* FAQ Interactive Accordion */
        .faq-container {
            max-width: 820px;
            margin: 0 auto;
        }

        .faq-item {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            border-radius: 20px;
            margin-bottom: 14px;
            overflow: hidden;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .faq-item.active {
            border-color: #93c5fd;
            box-shadow: 0 6px 0 #bfdbfe;
        }

        .faq-question {
            padding: 20px 24px;
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            transition: color 0.15s ease;
        }

        .faq-question:hover {
            color: var(--primary-blue);
        }

        .faq-chevron {
            transition: transform 0.25s ease;
            color: #64748b;
        }

        .faq-item.active .faq-chevron {
            transform: rotate(180deg);
            color: var(--primary-blue);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0, 1, 0, 1), padding 0.3s ease;
            padding: 0 24px;
            font-size: 14px;
            color: #475569;
            line-height: 1.65;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
            padding-bottom: 22px;
            transition: max-height 0.3s ease-in-out, padding 0.3s ease;
        }

        /* Final Conversion Card */
        .final-cta-card {
            max-width: 1080px;
            margin: 60px auto 0 auto;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 32px;
            padding: 48px 32px;
            text-align: center;
            color: #ffffff;
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.3), 0 6px 0 #1e40af;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 50px 24px 30px 24px;
            font-size: 14px;
        }

        .footer-content {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 30px;
            margin-bottom: 24px;
        }

        /* Mascot Showcase Banner Card (Naufal Academy / Duolingo Style) */
        .mascot-banner-wrapper {
            max-width: 980px;
            width: 100%;
            margin: clamp(28px, 4vw, 44px) auto 0 auto;
            position: relative;
            z-index: 20;
        }

        .mascot-banner-card {
            background: #ffffff;
            border: 2.5px solid #dbeafe;
            border-radius: clamp(20px, 2.5vw, 32px);
            padding: clamp(20px, 3vw, 32px);
            display: grid;
            grid-template-columns: minmax(240px, 320px) 1fr;
            align-items: center;
            gap: clamp(20px, 3vw, 36px);
            box-shadow: 0 16px 40px -10px rgba(37, 99, 235, 0.12), 0 6px 0 #bfdbfe;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: left;
        }

        .mascot-banner-card:hover {
            box-shadow: 0 20px 48px -10px rgba(37, 99, 235, 0.16), 0 8px 0 #93c5fd;
        }

        .mascot-img-box {
            position: relative;
            border-radius: clamp(16px, 2vw, 24px);
            overflow: hidden;
            background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 100%);
            border: 2px solid #c7d2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 4/3;
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.08);
        }

        .mascot-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }

        .mascot-img-box:hover img {
            transform: scale(1.04);
        }

        .mascot-floating-tag {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 800;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            line-height: 1.2;
        }

        .mascot-text-box h2 {
            font-size: clamp(20px, 2.2vw, 28px);
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.6px;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .mascot-text-box p {
            font-size: clamp(13px, 1.3vw, 14.5px);
            color: #475569;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .mascot-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            color: var(--primary-blue);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }

        .mascot-cta-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .mascot-stats-grid {
            display: flex;
            align-items: center;
            gap: clamp(10px, 2vw, 16px);
            flex-wrap: wrap;
            margin-top: 16px;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }

        .mascot-stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: #475569;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .mascot-banner-card {
                grid-template-columns: minmax(200px, 260px) 1fr;
                gap: 20px;
                padding: 24px;
            }
        }

        @media (max-width: 860px) {
            .mascot-banner-card {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 20px;
                padding: 24px 20px;
            }
            .mascot-img-box {
                max-width: 280px;
            }
            .mascot-text-box {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .mascot-cta-group {
                justify-content: center;
            }
            .mascot-stats-grid {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 26px;
                letter-spacing: -0.5px;
            }
            .hero-subtitle {
                font-size: 13.5px;
            }
            .section-header-white h2,
            .section-header-dark h2 {
                font-size: 22px;
            }
            .languages-grid {
                grid-template-columns: 1fr;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .steps-grid {
                grid-template-columns: 1fr;
            }
            .simulator-body {
                padding: 16px;
            }
            .final-cta-card {
                padding: 32px 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Unified Full Width Top Navigation Bar -->
    <header class="navbar-wrapper" id="navbar">
        <div class="navbar-inner">
            <a href="/" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; flex-shrink: 0; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #1d4ed8); display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 3px 0 #1e40af;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div>
                    <span style="font-size: 20px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">EDUSKILL</span>
                    <span style="font-size: 8px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
                </div>
            </a>

            <div style="display: flex; align-items: center; gap: 8px;">
                @auth
                    <a href="{{ route('learn.index') }}" class="btn-3d btn-blue" style="padding: 10px 18px; font-size: 13px;">
                        Roadmap Belajar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-3d btn-outline" style="padding: 10px 16px; font-size: 13px;">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-3d btn-blue" style="padding: 10px 18px; font-size: 13px;">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- SECTION 1: HERO & INTERACTIVE SIMULATOR WITH AMBIENT BACKGROUND & DECORATIONS -->
    <section class="hero-wrapper" id="hero">
        
        <!-- Ambient Glow Mesh Layer -->
        <div class="ambient-glow-orb orb-blue"></div>
        <div class="ambient-glow-orb orb-emerald"></div>
        <div class="ambient-glow-orb orb-purple"></div>
        <div class="ambient-glow-orb orb-amber"></div>

        <!-- Tech Matrix Blueprint Grid Pattern -->
        <div class="hero-matrix-grid"></div>

        <!-- Background Floating Code Badges & Logic Tokens (Gently Drifting) -->
        <div class="bg-code-token anim-token-1" style="top: 7%; left: 7%;">
            <div class="token-glass-badge">
                <span style="color: #2563eb;">def</span> <span style="color: #059669;">main</span>(): <span style="color: #64748b;">// start</span>
            </div>
        </div>

        <div class="bg-code-token anim-token-2" style="top: 8%; right: 7%;">
            <div class="token-glass-badge">
                <span style="color: #8b5cf6;">const</span> <span style="color: #d97706;">score</span> = <span style="color: #2563eb;">100</span>;
            </div>
        </div>

        <div class="bg-code-token anim-token-3" style="top: 34%; left: 8%;">
            <div class="token-symbol">{ &nbsp; }</div>
        </div>

        <div class="bg-code-token anim-token-4" style="top: 32%; right: 8%;">
            <div class="token-glass-badge">
                <span style="color: #059669;">&lt;code&gt;</span> <span style="color: #2563eb;">active</span> <span style="color: #059669;">/&gt;</span>
            </div>
        </div>

        <div class="bg-code-token anim-token-2" style="top: 65%; left: 7%;">
            <div class="token-glass-badge">
                <span style="color: #d97706;">while</span> streak &gt; 0:
            </div>
        </div>

        <div class="bg-code-token anim-token-1" style="top: 67%; right: 7%;">
            <div class="token-glass-badge">
                <span style="color: #2563eb;">return</span> <span style="color: #059669;">"Success!"</span>
            </div>
        </div>

        <div class="bg-code-token anim-token-3" style="top: 86%; left: 14%;">
            <div class="token-symbol">&lt; / &gt;</div>
        </div>

        <div class="bg-code-token anim-token-4" style="top: 88%; right: 14%;">
            <div class="token-symbol">[ 0 .. n ]</div>
        </div>

        <!-- Side Floating Gamified Decorations (Flanking the Margins) -->
        <div class="side-float-container">
            <!-- Left Side Floaties -->
            <div class="float-item float-left-1" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #fef2f2; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ef4444;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: #dc2626;">5 / 5 Nyawa</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Siap Kuis</div>
                </div>
            </div>

            <div class="float-item float-left-2" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #fffbeb; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #d97706;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: #d97706;">7 Hari Streak</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Konsisten</div>
                </div>
            </div>

            <div class="float-item float-left-3" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: #2563eb;">Puzzle Kode</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Parsons Mode</div>
                </div>
            </div>

            <!-- Right Side Floaties -->
            <div class="float-item float-right-1" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: var(--primary-blue);">250 Gems</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Bonus Harian</div>
                </div>
            </div>

            <div class="float-item float-right-2" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: #059669;">+50 XP Poin</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Liga Berlian</div>
                </div>
            </div>

            <div class="float-item float-right-3" onclick="triggerBadgePop(this)">
                <div style="width: 34px; height: 34px; background: #fdf4ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #c026d3;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 900; color: #c026d3;">Sertifikat QR</div>
                    <div style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Valid Digital</div>
                </div>
            </div>
        </div>

        <div class="hero-container">
            
            <div class="hero-tag" id="hero-tag">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Platform Belajar Interaktif SMP &amp; SMA
            </div>

            <h1 class="hero-title" id="hero-title">
                Belajar Coding Menyenangkan Seperti <span>Bermain Game</span>
            </h1>

            <p class="hero-subtitle" id="hero-subtext">
                Kuasai logika algoritma pemrograman dasar, susun baris kode dengan puzzle interaktif, pertahankan streak harian, dan raih sertifikat resmi ber-QR publik.
            </p>

            <div class="hero-cta-group" id="hero-ctas">
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="font-size: 15px; padding: 16px 32px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    Mulai Petualangan
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="font-size: 15px; padding: 16px 24px;">
                    Demo Akun Uji Coba
                </a>
            </div>

            <!-- Clean Integrated Simulator Box -->
            <div class="simulator-box" id="simulator-card">
                
                <div class="simulator-top-bar">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="simulator-dots">
                            <div class="dot dot-red"></div>
                            <div class="dot dot-yellow"></div>
                            <div class="dot dot-green"></div>
                        </div>
                        <div class="code-font" style="font-size: 12px; font-weight: 700; color: #64748b; display: flex; align-items: center; gap: 6px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                            simulasi_tantangan.py
                        </div>
                    </div>

                    <!-- Clean Integrated HUD Pills -->
                    <div class="hud-status-group">
                        <div class="hud-pill heart">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                            5 Nyawa
                        </div>
                        <div class="hud-pill gems">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 3h12l4 6-10 13L2 9Z"></path></svg>
                            250 Gems
                        </div>
                        <div class="hud-pill streak">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                            7 Hari
                        </div>
                    </div>
                </div>

                <div class="simulator-body">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: var(--primary-blue-light); padding: 3px 8px; border-radius: 8px;">KUIS INTERAKTIF</span>
                        <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Pilih perintah yang tepat untuk menampilkan teks ke layar:</span>
                    </div>

                    <!-- Code Snippet -->
                    <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 16px;">
                        <div class="code-font" style="font-size: 13px; line-height: 1.7; color: #1e293b;">
                            <span id="slot-placeholder" style="display: inline-block; min-width: 70px; padding: 3px 10px; background: #ffffff; border: 2px dashed #94a3b8; border-radius: 8px; color: var(--primary-blue); font-weight: 700; text-align: center;">...</span>(<span style="color: #d97706;">"Selamat Datang di EduSkill!"</span>)
                        </div>
                    </div>

                    <!-- Options -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; justify-content: center;">
                        <button type="button" class="quiz-chip" data-choice="input" onclick="chooseOption(this, false)">input</button>
                        <button type="button" class="quiz-chip" data-choice="print" onclick="chooseOption(this, true)">print</button>
                        <button type="button" class="quiz-chip" data-choice="echo" onclick="chooseOption(this, false)">echo</button>
                    </div>

                    <!-- Feedback Alert -->
                    <div id="quiz-feedback-box" style="background: #0f172a; border-radius: 14px; padding: 12px 16px; color: #38bdf8; font-size: 12px; font-family: 'Fira Code', monospace; min-height: 46px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #64748b;">&gt;</span>
                            <span id="quiz-feedback-text">Klik salah satu opsi jawaban untuk melihat hasilnya...</span>
                        </div>
                        <span id="quiz-xp-badge" style="display: none; background: #059669; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">+10 XP</span>
                    </div>
                </div>

            </div>

            <!-- CUTE MASCOT SHOWCASE BANNER (Naufal Academy / Duolingo Style) -->
            <div class="mascot-banner-wrapper">
                <div class="mascot-banner-card">
                    <div class="mascot-img-box">
                        <img src="/images/mascot.jpg" alt="EduSkill Mascot Otter Kiko">
                        <div class="mascot-floating-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>Maskot EduSkill: Kiko Si Berang-Berang Pintar</span>
                        </div>
                    </div>
                    <div class="mascot-text-box">
                        <div class="mascot-pill-badge">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            Gamifikasi Belajar Coding
                        </div>
                        <h2>Udah Saatnya Belajar Coding Jadi Seru &amp; Gak Ngebosenin!</h2>
                        <p>Gabung sekarang bareng <strong>10.000+ pelajar SMP &amp; SMA</strong> lainnya yang udah asyik taklukkan logika coding dari nol sampai siap bikin aplikasi impian.</p>
                        
                        <div class="mascot-cta-group">
                            <a href="{{ route('register') }}" class="btn-3d btn-blue" style="font-size: 14px; padding: 14px 28px;">
                                Mulai Sekarang (Gratis)
                            </a>
                            <a href="#languages" class="btn-3d btn-outline" style="font-size: 14px; padding: 14px 20px; background: #ffffff;">
                                Jelajahi Kursus
                            </a>
                        </div>

                        <div class="mascot-stats-grid">
                            <div class="mascot-stat-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>100% Interaktif</span>
                            </div>
                            <div class="mascot-stat-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>5 Menit / Hari</span>
                            </div>
                            <div class="mascot-stat-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Sertifikat Digital</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Wave Divider 1: Transition into Languages Catalog -->
    <div class="wave-curve-1">
        <svg viewBox="0 0 1440 90" fill="none" preserveAspectRatio="none">
            <path d="M0,30 C360,90 720,0 1080,60 C1260,85 1380,40 1440,30 L1440,90 L0,90 Z" fill="#1d4ed8"></path>
        </svg>
    </div>

    <!-- SECTION 2: PROGRAMMING LANGUAGES CATALOG -->
    <section class="languages-section" id="languages">
        <div class="section-header-white">
            <div class="tag-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                Pilihan Kurikulum &amp; Topik
            </div>
            <h2>Jalur Bahasa Pemrograman Sesuai Minatmu</h2>
            <p>Mulai dari logika komputasi paling mendasar hingga pembuatan aplikasi web modern.</p>
        </div>

        <div class="languages-grid">
            
            {{-- 1. Active & Playable Courses From Database --}}
            @forelse ($activeCourses ?? [] as $course)
                @php
                    $isPython = str_contains(strtolower($course->title), 'python');
                    $isWeb = str_contains(strtolower($course->title), 'web') || str_contains(strtolower($course->title), 'html');
                    $isAlgo = str_contains(strtolower($course->title), 'algoritma') || str_contains(strtolower($course->title), 'logika');

                    $iconBg = $isPython ? '#eff6ff' : ($isWeb ? '#fff7ed' : ($isAlgo ? '#fdf4ff' : '#f0fdf4'));
                    $iconColor = $isPython ? '#2563eb' : ($isWeb ? '#ea580c' : ($isAlgo ? '#c026d3' : '#16a34a'));
                    $badgeColor = $isPython ? '#059669' : ($isWeb ? '#ea580c' : ($isAlgo ? '#c026d3' : '#2563eb'));
                @endphp
                <div class="lang-card">
                    <div>
                        <div class="lang-header">
                            <div class="lang-icon-box" style="background: {{ $iconBg }}; color: {{ $iconColor }};">
                                @if ($isPython)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m10 15 5-3-5-3v6Z"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path></svg>
                                @elseif ($isWeb)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                @elseif ($isAlgo)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                @else
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                                @endif
                            </div>
                            <div>
                                <h3 style="font-size: 18px; font-weight: 900; color: #0f172a;">{{ $course->title }}</h3>
                                <span style="font-size: 12px; color: {{ $badgeColor }}; font-weight: 800; text-transform: uppercase;">
                                    Tingkat: {{ ucfirst($course->level) }} ({{ $course->target_audience ?? 'SMP/SMA' }})
                                </span>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 13px; line-height: 1.6;">
                            {{ $course->description ?: 'Pelajari konsep fundamental dan latihan interaktif berbasis puzzle untuk menguasai topik ini.' }}
                        </p>
                        <div class="lang-pill-tags">
                            <span class="lang-pill-tag">{{ $course->category }}</span>
                            <span class="lang-pill-tag">{{ $course->units->count() }} Unit &bull; {{ $course->lessons_count ?? $course->lessons->count() }} Modul</span>
                            <span class="lang-pill-tag">Sertifikat Valid QR</span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px; margin-top: 6px;">
                        <span style="font-size: 12px; font-weight: 800; color: var(--primary-blue);">Total {{ $course->total_xp }} XP</span>
                        @auth
                            <a href="{{ route('learn.index', ['course_id' => $course->id]) }}" class="btn-3d btn-blue" style="padding: 8px 16px; font-size: 12px; border-radius: 12px;">Mulai Belajar</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-3d btn-blue" style="padding: 8px 16px; font-size: 12px; border-radius: 12px;">Pelajari</a>
                        @endauth
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; background: rgba(255,255,255,0.1); border-radius: 20px; padding: 30px; color: #fff;">
                    Belum ada kursus aktif.
                </div>
            @endforelse

            {{-- 2. Upcoming Roadmap Courses From Database --}}
            @foreach ($upcomingCourses ?? [] as $upcoming)
                @php
                    $isJS = str_contains(strtolower($upcoming->title), 'javascript');
                    $isCpp = str_contains(strtolower($upcoming->title), 'c++') || str_contains(strtolower($upcoming->title), 'olimpiade');
                    $isSql = str_contains(strtolower($upcoming->title), 'sql') || str_contains(strtolower($upcoming->title), 'database') || str_contains(strtolower($upcoming->title), 'basis data');

                    $upBg = $isJS ? '#fefce8' : ($isCpp ? '#f0fdf4' : ($isSql ? '#f1f5f9' : '#fffbeb'));
                    $upColor = $isJS ? '#ca8a04' : ($isCpp ? '#16a34a' : ($isSql ? '#0284c7' : '#d97706'));
                @endphp
                <div class="lang-card">
                    <div>
                        <div class="lang-header">
                            <div class="lang-icon-box" style="background: {{ $upBg }}; color: {{ $upColor }};">
                                @if ($isJS)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                @elseif ($isCpp)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="9" y="9" width="6" height="6"></rect></svg>
                                @elseif ($isSql)
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                @else
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                @endif
                            </div>
                            <div>
                                <h3 style="font-size: 18px; font-weight: 900; color: #0f172a;">{{ $upcoming->title }}</h3>
                                <span style="font-size: 12px; color: {{ $upColor }}; font-weight: 800; text-transform: uppercase;">
                                    Tingkat: {{ ucfirst($upcoming->level) }} &bull; Roadmap Mendatang
                                </span>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 13px; line-height: 1.6;">
                            {{ $upcoming->description ?: 'Materi kurikulum masa depan yang sedang disusun oleh mentor kami.' }}
                        </p>
                        <div class="lang-pill-tags">
                            <span class="lang-pill-tag">{{ $upcoming->category }}</span>
                            <span class="lang-pill-tag">{{ $upcoming->target_audience ?? 'Siswa SMP & SMA' }}</span>
                            <span class="lang-pill-tag" style="background: #fef3c7; color: #b45309; font-weight: 800;">Segera Rilis</span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px; margin-top: 6px;">
                        <span style="font-size: 12px; font-weight: 800; color: #b45309;">Roadmap Mendatang</span>
                        <a href="{{ route('register') }}" class="btn-3d btn-outline" style="padding: 8px 16px; font-size: 12px; border-radius: 12px;">Daftar Dulu</a>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <!-- Wave Divider 2: Transition from Blue to White -->
    <div class="wave-curve-2">
        <svg viewBox="0 0 1440 90" fill="none" preserveAspectRatio="none">
            <path d="M0,60 C360,0 720,90 1080,30 C1260,10 1380,50 1440,60 L1440,90 L0,90 Z" fill="#ffffff"></path>
        </svg>
    </div>

    <!-- SECTION 3: GAMIFIED FEATURES -->
    <section class="features-section" id="features">
        <div class="section-header-dark">
            <div class="tag-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Fitur Unggulan
            </div>
            <h2>Belajar Seru Tanpa Frustrasi Sintaks</h2>
            <p>Fitur interaktif yang didesain agar siswa SMP &amp; SMA menikmati proses belajar setiap hari.</p>
        </div>

        <div class="features-grid">
            
            <div class="feature-card">
                <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; flex-shrink: 0; border-radius: 14px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                </div>
                <h3 style="font-size: 17px; font-weight: 900; margin-bottom: 8px;">Parsons Code Ordering</h3>
                <p style="color: #64748b; font-size: 13px; line-height: 1.6;">Susun balok baris kode layaknya puzzle untuk melatih alur logika tanpa takut frustrasi salah tanda kurung.</p>
            </div>

            <div class="feature-card">
                <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; flex-shrink: 0; border-radius: 14px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                </div>
                <h3 style="font-size: 17px; font-weight: 900; margin-bottom: 8px;">Gamifikasi Nyawa &amp; Streak</h3>
                <p style="color: #64748b; font-size: 13px; line-height: 1.6;">Jaga nyawa belajarmu, kumpulkan gems berharga, dan pertahankan streak api setiap hari agar makin konsisten.</p>
            </div>

            <div class="feature-card">
                <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; flex-shrink: 0; border-radius: 14px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                </div>
                <h3 style="font-size: 17px; font-weight: 900; margin-bottom: 8px;">Liga &amp; Papan Peringkat</h3>
                <p style="color: #64748b; font-size: 13px; line-height: 1.6;">Raih posisi podium teratas di Liga Berlian mingguan dan pamerkan lencana pencapaian di profilmu.</p>
            </div>

            <div class="feature-card">
                <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; flex-shrink: 0; border-radius: 14px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                </div>
                <h3 style="font-size: 17px; font-weight: 900; margin-bottom: 8px;">Sertifikat Valid QR</h3>
                <p style="color: #64748b; font-size: 13px; line-height: 1.6;">Tuntaskan seluruh modul untuk menerbitkan sertifikat resmi digital yang bisa diverifikasi secara publik via QR Code.</p>
            </div>

        </div>
    </section>

    <!-- Wave Curve 3: Transition from White into Light Blue Steps & FAQ -->
    <div class="wave-curve-3">
        <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none">
            <path d="M0,20 C360,70 720,10 1080,50 C1260,70 1380,30 1440,20 L1440,80 L0,80 Z" fill="#f0f7ff"></path>
        </svg>
    </div>

    <!-- SECTION 4: 3-STEP JOURNEY & INTERACTIVE FAQ ACCORDION -->
    <section class="steps-faq-section">
        
        <!-- Steps Sub-Section -->
        <div class="section-header-dark" style="margin-bottom: 36px;">
            <div class="tag-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                Alur Belajar
            </div>
            <h2>3 Langkah Mudah Memulai di EduSkill</h2>
            <p>Mulai perjalanan belajarmu dengan langkah sederhana dan terarah.</p>
        </div>

        <div class="steps-grid">
            <div class="step-box">
                <div class="step-number">1</div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Pilih Topik Belajar</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Pilih bahasa pemrograman yang ingin kamu kuasai, mulai dari Python, HTML/CSS, hingga Logika Algoritma.</p>
            </div>

            <div class="step-box">
                <div class="step-number">2</div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Selesaikan Kuis &amp; Puzzle</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Taklukkan tantangan interaktif per modul, kumpulkan poin XP, dan naikkan peringkat mingguanmu.</p>
            </div>

            <div class="step-box">
                <div class="step-number">3</div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Klaim Sertifikat Resmi</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Setelah menyelesaikan 100% kurikulum, terbitkan sertifikat kelulusan ber-QR publik yang bisa kamu cantumkan di portofolio.</p>
            </div>
        </div>

        <!-- FAQ Sub-Section -->
        <div class="faq-container">
            <div class="section-header-dark" style="margin-bottom: 30px;">
                <div class="tag-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Tanya Jawab
                </div>
                <h2>Pertanyaan yang Sering Diajukan</h2>
                <p>Klik pertanyaan di bawah untuk melihat penjelasan lengkapnya.</p>
            </div>

            <!-- FAQ Item 1 (Active by Default) -->
            <div class="faq-item active">
                <div class="faq-question">
                    <span>Apakah platform ini cocok untuk pemula yang belum pernah coding?</span>
                    <div class="faq-chevron">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="faq-answer">
                    Sangat cocok! EduSkill dirancang khusus untuk siswa SMP dan SMA. Metode belajarnya menggunakan kuis interaktif, pilihan berganda, dan susun baris kode (Parsons Problem) sehingga kamu tidak perlu pusing menghafal sintaks yang rumit di awal.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Apakah bisa diakses lewat handphone atau tablet?</span>
                    <div class="faq-chevron">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="faq-answer">
                    Bisa banget! Seluruh tampilan EduSkill sudah dioptimasi secara responsif untuk smartphone, tablet, maupun laptop/desktop komputer sekolah tanpa perlu install aplikasi tambahan.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Bagaimana cara memverifikasi sertifikat yang didapat?</span>
                    <div class="faq-chevron">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="faq-answer">
                    Setiap sertifikat memiliki kode unik dan QR Code resmi. Siapapun (guru, orang tua, teman) dapat memindai QR Code tersebut untuk langsung melihat halaman verifikasi kelulusan asli secara publik di internet.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Bagaimana jika nyawa belajar saya habis saat salah kuis?</span>
                    <div class="faq-chevron">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="faq-answer">
                    Jangan khawatir! Kamu bisa me-refill nyawa belajarmu secara instan menggunakan Gems yang kamu dapatkan setiap kali menyelesaikan kuis harian, atau nyawamu akan terisi kembali secara berkala.
                </div>
            </div>
        </div>

        <!-- Final Conversion Card -->
        <div class="final-cta-card">
            <h2 style="font-size: 32px; font-weight: 900; margin-bottom: 12px; letter-spacing: -0.5px;">
                Siap Menjadi Programmer Muda Berbakat?
            </h2>
            <p style="color: #bfdbfe; font-size: 15px; max-width: 540px; margin: 0 auto 28px auto; line-height: 1.6;">
                Daftar sekarang secara gratis dan mulai petualangan belajarmu bersama teman-teman sekolah di EduSkill!
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="btn-3d btn-white" style="font-size: 15px; padding: 15px 32px;">
                    Daftar Akun Gratis
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="font-size: 15px; padding: 15px 24px; background: rgba(255,255,255,0.12); color: #ffffff; border-color: rgba(255,255,255,0.4); box-shadow: 0 4px 0 rgba(0,0,0,0.2);">
                    Masuk ke Akun
                </a>
            </div>
        </div>

    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #2563eb; display: flex; align-items: center; justify-content: center; color: #fff;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div>
                    <span style="font-size: 18px; font-weight: 900; color: #ffffff; letter-spacing: -0.5px;">EDUSKILL</span>
                    <span style="font-size: 9px; font-weight: 800; display: block; color: #64748b;">PLATFORM PEMROGRAMAN INTERAKTIF</span>
                </div>
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <a href="{{ route('learn.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 700;">Roadmap Belajar</a>
                <a href="{{ route('leaderboard.web') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 700;">Papan Peringkat</a>
                <a href="{{ route('login') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 700;">Masuk Akun</a>
                <a href="{{ route('register') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 700;">Daftar Siswa</a>
            </div>
        </div>
        <div style="max-width: 1140px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; font-size: 12px;">
            <span>&copy; {{ date('Y') }} EduSkill Learning Platform. Dikembangkan khusus untuk siswa SMP &amp; SMA.</span>
            <span>Semua hak dilindungi undang-undang.</span>
        </div>
    </footer>

    <!-- Interactive Scripts & Micro-Interactions -->
    <script>
        // Interactive Mini-Quiz Handler
        function chooseOption(btn, isCorrect) {
            const placeholder = document.getElementById('slot-placeholder');
            const feedbackText = document.getElementById('quiz-feedback-text');
            const xpBadge = document.getElementById('quiz-xp-badge');
            const choice = btn.getAttribute('data-choice');

            document.querySelectorAll('.quiz-chip').forEach(chip => {
                chip.classList.remove('selected-correct', 'selected-wrong');
            });

            placeholder.innerText = choice;

            if (isCorrect) {
                if (window.EduAudio) window.EduAudio.playCorrect();
                btn.classList.add('selected-correct');
                placeholder.style.borderColor = '#10b981';
                placeholder.style.color = '#059669';
                placeholder.style.background = '#ecfdf5';

                feedbackText.style.color = '#4ade80';
                feedbackText.innerText = 'Benar! Output: "Selamat Datang di EduSkill!"';
                xpBadge.style.display = 'inline-block';

                confetti({
                    particleCount: 60,
                    spread: 60,
                    origin: { y: 0.65 }
                });
            } else {
                if (window.EduAudio) window.EduAudio.playWrong();
                btn.classList.add('selected-wrong');
                placeholder.style.borderColor = '#ef4444';
                placeholder.style.color = '#dc2626';
                placeholder.style.background = '#fef2f2';

                feedbackText.style.color = '#f87171';
                feedbackText.innerText = 'Kurang tepat. Coba pilih fungsi "print" ya!';
                xpBadge.style.display = 'none';
            }
        }

        // Side badge pop confetti on click
        function triggerBadgePop(el) {
            if (window.EduAudio) window.EduAudio.playSelect();
            confetti({
                particleCount: 35,
                spread: 45,
                origin: { y: 0.6 }
            });
            if (typeof gsap !== 'undefined') {
                gsap.fromTo(el, { scale: 0.88 }, { scale: 1.15, yoyo: true, repeat: 1, duration: 0.2 });
            }
        }

        // FAQ Accordion Interactive Toggle
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', () => {
                    if (window.EduAudio) window.EduAudio.playTap();
                    const item = question.closest('.faq-item');
                    const wasActive = item.classList.contains('active');
                    
                    // Close other items
                    document.querySelectorAll('.faq-item').forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });

                    // Toggle clicked item
                    if (!wasActive) {
                        item.classList.add('active');
                    }
                });
            });

            // Global tap feedback for 3D buttons on landing page
            document.addEventListener('click', (e) => {
                const target = e.target.closest('.btn-3d, .quiz-chip, .pill-tag, .lang-card');
                if (target && window.EduAudio) {
                    window.EduAudio.playTap();
                }
            }, { passive: true });

            // Entrance GSAP Animations
            if (typeof gsap !== 'undefined') {
                const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

                tl.from("#navbar", { y: -30, opacity: 0, duration: 0.6 })
                  .from("#hero-tag", { scale: 0.8, opacity: 0, duration: 0.5, ease: "back.out(1.7)" }, "-=0.3")
                  .from("#hero-title", { y: 25, opacity: 0, duration: 0.6 }, "-=0.3")
                  .from("#hero-subtext", { y: 20, opacity: 0, duration: 0.5 }, "-=0.3")
                  .from("#hero-ctas .btn-3d", { y: 15, opacity: 0, stagger: 0.1, duration: 0.5 }, "-=0.2")
                  .from("#simulator-card", { scale: 0.95, opacity: 0, duration: 0.7, ease: "back.out(1.2)" }, "-=0.4")
                  .from(".mascot-banner-card", { y: 30, opacity: 0, duration: 0.6, ease: "power2.out" }, "-=0.3")
                  .from(".float-item", { scale: 0.5, opacity: 0, stagger: 0.08, duration: 0.6, ease: "back.out(1.7)" }, "-=0.3");
            }
        });
    </script>
    <script src="{{ asset('js/audio-engine.js') }}"></script>
</body>
</html>
