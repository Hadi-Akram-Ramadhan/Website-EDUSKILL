<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Kodein - Platform Belajar Coding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --primary-blue-light: #eff6ff;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
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
            padding: 24px 16px;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 28px;
            padding: 40px 32px;
            box-shadow: 0 4px 0 #e2e8f0;
        }

        .logo-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 18px;
            color: #fff;
            box-shadow: 0 4px 0 #1e40af;
            margin-bottom: 12px;
        }

        .btn-3d {
            width: 100%;
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
            padding: 14px 20px;
            font-size: 14px;
            text-decoration: none;
            transition: transform 0.1s;
        }
        .btn-3d:active { transform: translateY(4px); }

        .btn-blue {
            background: var(--primary-blue);
            color: #fff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }
        .btn-blue:active { box-shadow: 0 0 0 var(--primary-blue-shadow); }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 14px 18px;
            color: var(--text-main);
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: var(--primary-blue);
        }

        .quick-accounts {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 2px dashed var(--border-color);
        }

        .account-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 10px 14px;
            margin-bottom: 10px;
            text-decoration: none;
            color: var(--text-main);
            transition: all 0.15s;
        }

        .account-chip:hover {
            border-color: var(--primary-blue);
            transform: translateX(4px);
            background: var(--primary-blue-light);
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo-header">
            <div class="logo-badge">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <h1 style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Masuk ke Kodein</h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 4px;">Lanjutkan petualangan coding dan jaga streak belajar kamu.</p>
        </div>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 14px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #dc2626;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.login.submit') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="contoh: budi@smp.sch.id" required autofocus>
            </div>

            <div class="input-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" class="input-field" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-3d btn-blue" style="margin-top: 8px;">
                Masuk Sekarang
            </button>
        </form>

        <div style="text-align: center; margin-top: 18px; font-size: 14px; color: var(--text-muted);">
            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary-blue); font-weight: 800; text-decoration: none;">Daftar Akun Baru</a>
        </div>

        <!-- 1-Click Quick Demo Login -->
        <div class="quick-accounts">
            <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                <span>Demo Akun Uji Coba:</span>
                <span style="color: var(--primary-blue);">Klik untuk Masuk</span>
            </div>

            @foreach ($demoUsers as $user)
                <a href="{{ route('auth.quick-login', $user->id) }}" class="account-chip">
                    <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $user->id }}" style="width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0;" alt="">
                    <div style="flex: 1;">
                        <div style="font-size: 13px; font-weight: 800;">{{ $user->name }}</div>
                        <div style="font-size: 11px; color: var(--text-muted);">{{ $user->email }}</div>
                    </div>
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 8px; border-radius: 8px; background: {{ $user->role === 'guru' ? '#dbeafe' : ($user->role === 'super_admin' ? '#f3e8ff' : '#ecfdf5') }}; color: {{ $user->role === 'guru' ? '#1d4ed8' : ($user->role === 'super_admin' ? '#7e22ce' : '#047857') }};">
                        {{ $user->role }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
