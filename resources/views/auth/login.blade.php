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
            --duo-green: #58cc02;
            --duo-green-shadow: #46a302;
            --duo-blue: #1cb0f6;
            --duo-blue-shadow: #1899d6;
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
            padding: 40px 32px;
            box-shadow: 0 8px 0 var(--duo-border);
        }

        .logo-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #58cc02, #46a302);
            border-radius: 20px;
            font-size: 32px;
            box-shadow: 0 4px 0 #3a8a00;
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
        .btn-green:active { box-shadow: 0 0 0 var(--duo-green-shadow); }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            background: #131f24;
            border: 2px solid var(--duo-border);
            border-radius: 16px;
            padding: 14px 18px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: var(--duo-blue);
        }

        .quick-accounts {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 2px dashed var(--duo-border);
        }

        .account-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #131f24;
            border: 2px solid var(--duo-border);
            border-radius: 16px;
            padding: 10px 14px;
            margin-bottom: 10px;
            text-decoration: none;
            color: #fff;
            transition: all 0.15s;
        }

        .account-chip:hover {
            border-color: var(--duo-green);
            transform: translateX(4px);
            background: #17262d;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo-header">
            <div class="logo-badge">⚡</div>
            <h1 style="font-size: 26px; font-weight: 900; letter-spacing: -0.5px;">Masuk ke Kodein</h1>
            <p style="color: #94a3b8; font-size: 14px; margin-top: 4px;">Lanjutkan petualangan coding dan jaga streak-mu! 🔥</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 2px solid #ef4444; border-radius: 14px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
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

            <button type="submit" class="btn-3d btn-green" style="margin-top: 8px;">
                MASUK SEKARANG 🚀
            </button>
        </form>

        <div style="text-align: center; margin-top: 18px; font-size: 14px; color: #94a3b8;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: #38bdf8; font-weight: 800; text-decoration: none;">Daftar Akun Baru</a>
        </div>

        <!-- 1-Click Quick Demo Login -->
        <div class="quick-accounts">
            <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                <span>⚡ 1-Click Demo Login:</span>
                <span style="color: var(--duo-gold);">Siap Dicoba</span>
            </div>

            @foreach ($demoUsers as $user)
                <a href="{{ route('auth.quick-login', $user->id) }}" class="account-chip">
                    <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $user->id }}" style="width: 32px; height: 32px; border-radius: 50%; background: #202f36;" alt="">
                    <div style="flex: 1;">
                        <div style="font-size: 13px; font-weight: 800;">{{ $user->name }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $user->email }}</div>
                    </div>
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 8px; border-radius: 8px; background: {{ $user->role === 'guru' ? '#1899d6' : ($user->role === 'super_admin' ? '#ce82ff' : '#58cc02') }};">
                        {{ $user->role }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
