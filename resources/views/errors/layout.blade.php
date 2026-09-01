<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Terjadi Kendala') - EduSkill</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --accent-red: #ef4444;
            --accent-red-shadow: #dc2626;
            --accent-orange: #f59e0b;
            --accent-orange-shadow: #d97706;
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

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow & Matrix Grid Background */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        .glow-top {
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 550px;
            height: 350px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.2) 0%, rgba(37, 99, 235, 0) 70%);
        }

        .glow-side {
            bottom: -50px;
            right: 10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 70%);
        }

        .matrix-grid {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(rgba(37, 99, 235, 0.18) 1.5px, transparent 1.5px),
                linear-gradient(to right, rgba(203, 213, 225, 0.4) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(203, 213, 225, 0.4) 1px, transparent 1px);
            background-size: 32px 32px, 64px 64px, 64px 64px;
            background-position: center top;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, #000 30%, transparent 90%);
            -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, #000 30%, transparent 90%);
            pointer-events: none;
            z-index: 2;
        }

        /* 3D Chunky Buttons */
        .btn-3d {
            position: relative;
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
            padding: 12px 24px;
            font-size: 13px;
            text-decoration: none;
            user-select: none;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
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

        .btn-outline {
            background: #ffffff;
            color: #334155;
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-outline:active {
            box-shadow: 0 0 0 #cbd5e1;
        }

        /* Error Card Container */
        .error-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 540px;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 28px;
            padding: 44px 32px;
            text-align: center;
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.12), 0 6px 0 #cbd5e1;
        }

        .code-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 9999px;
            font-family: 'Fira Code', monospace;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .badge-blue { background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe; }
        .badge-amber { background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; }
        .badge-red { background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca; }

        .error-icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px auto;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; box-shadow: 0 4px 0 #bfdbfe; }
        .icon-amber { background: #fffbeb; color: #d97706; box-shadow: 0 4px 0 #fde68a; }
        .icon-red { background: #fef2f2; color: #dc2626; box-shadow: 0 4px 0 #fecaca; }

        .error-title {
            font-size: 24px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.5px;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .error-desc {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .actions-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .error-card {
                padding: 32px 20px;
            }
            .actions-row {
                flex-direction: column;
                width: 100%;
            }
            .actions-row .btn-3d {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-top"></div>
    <div class="ambient-glow glow-side"></div>
    <div class="matrix-grid"></div>

    <main class="error-card">
        @yield('content')
    </main>

</body>
</html>
