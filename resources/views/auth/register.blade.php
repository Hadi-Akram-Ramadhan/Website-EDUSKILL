<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - EduSkill</title>
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
            padding: 36px 32px;
            box-shadow: 0 4px 0 #e2e8f0;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 24px 18px;
                border-radius: 22px;
            }
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
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .input-field {
            width: 100%;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 12px 16px;
            color: var(--text-main);
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: var(--primary-blue);
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .role-option {
            background: #f8fafc;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .role-option input { display: none; }

        .role-option:has(input:checked) {
            border-color: var(--primary-blue);
            background: var(--primary-blue-light);
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; flex-shrink: 0; margin: 0 auto 12px auto; background: var(--primary-blue-light); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            </div>
            <h1 style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Buat Akun EduSkill</h1>
            <p style="color: var(--text-muted); font-size: 14px;">Mulai belajar pemrograman dasar dengan metode interaktif.</p>
        </div>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 14px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #dc2626;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.register.submit') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field" placeholder="Nama lengkap kamu" required autofocus>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="email@sekolah.sch.id" required>
            </div>

            <div class="input-group">
                <label>Peran Pengguna</label>
                <div class="role-selector">
                    <label class="role-option">
                        <input type="radio" name="role" value="siswa" checked>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                        <div style="font-weight: 800; font-size: 12px;">Siswa SMP / SMA</div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="guru">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                        <div style="font-weight: 800; font-size: 12px;">Guru / Mentor</div>
                    </label>
                </div>
            </div>

            <div class="input-group">
                <label>Kata Sandi (Min. 6 Karakter)</label>
                <input type="password" name="password" class="input-field" placeholder="••••••••" required>
            </div>

            <div class="input-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="input-field" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-3d btn-blue" style="margin-top: 12px;">
                Daftar Sekarang
            </button>
        </form>

        <div style="text-align: center; margin-top: 18px; font-size: 14px; color: var(--text-muted);">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary-blue); font-weight: 800; text-decoration: none;">Masuk di Sini</a>
        </div>
    </div>
</body>
</html>
