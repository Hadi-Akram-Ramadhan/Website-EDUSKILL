<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Kodein</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --duo-green: #58cc02;
            --duo-green-shadow: #46a302;
            --duo-blue: #1cb0f6;
            --duo-dark: #0e161a;
            --duo-card: #202f36;
            --duo-border: #37464f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--duo-dark);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: var(--duo-card);
            border: 2px solid var(--duo-border);
            border-radius: 28px;
            padding: 36px 32px;
            box-shadow: 0 8px 0 var(--duo-border);
        }

        .btn-3d {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 14px 20px;
            font-size: 15px;
            text-decoration: none;
            transition: transform 0.1s;
        }
        .btn-3d:active { transform: translateY(4px); }

        .btn-green {
            background: var(--duo-green);
            color: #fff;
            box-shadow: 0 4px 0 var(--duo-green-shadow);
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .input-field {
            width: 100%;
            background: #131f24;
            border: 2px solid var(--duo-border);
            border-radius: 16px;
            padding: 12px 16px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            outline: none;
        }

        .input-field:focus {
            border-color: var(--duo-blue);
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .role-option {
            background: #131f24;
            border: 2px solid var(--duo-border);
            border-radius: 16px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
        }

        .role-option input { display: none; }

        .role-option:has(input:checked) {
            border-color: var(--duo-green);
            background: rgba(88, 204, 2, 0.1);
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="font-size: 40px; margin-bottom: 8px;">🎮</div>
            <h1 style="font-size: 24px; font-weight: 900;">Buat Akun Kodein</h1>
            <p style="color: #94a3b8; font-size: 14px;">Belajar coding jadi seru dan menyenangkan!</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 2px solid #ef4444; border-radius: 14px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.register.submit') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field" placeholder="Nama kamu" required autofocus>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="email@sekolah.sch.id" required>
            </div>

            <div class="input-group">
                <label>Peran Kamu</label>
                <div class="role-selector">
                    <label class="role-option">
                        <input type="radio" name="role" value="siswa" checked>
                        <div style="font-size: 20px;">🎓</div>
                        <div style="font-weight: 800; font-size: 13px; margin-top: 4px;">Siswa SMP/SMA</div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="guru">
                        <div style="font-size: 20px;">👨‍🏫</div>
                        <div style="font-weight: 800; font-size: 13px; margin-top: 4px;">Guru / Mentor</div>
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

            <button type="submit" class="btn-3d btn-green" style="margin-top: 12px;">
                DAFTAR GRATIS 🚀
            </button>
        </form>

        <div style="text-align: center; margin-top: 18px; font-size: 14px; color: #94a3b8;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #38bdf8; font-weight: 800; text-decoration: none;">Masuk di Sini</a>
        </div>
    </div>
</body>
</html>
