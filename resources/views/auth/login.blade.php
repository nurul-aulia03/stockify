<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Stockify</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --purple: #6d28d9;
            --purple-dark: #5b21b6;
            --purple-light: #f3e8ff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(ellipse at top left, #ede9fe 0, transparent 45%),
                radial-gradient(ellipse at bottom right, #ddd6fe 0, transparent 40%),
                #f8f7fc;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 40px;
            background: #ffffff;
            border: 1px solid #ede9fe;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(76, 29, 149, 0.12);
        }

        .brand {
            margin-bottom: 34px;
            text-align: center;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 62px;
            margin: 0 auto 14px;
            border-radius: 18px;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            color: white;
            font-size: 30px;
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(109, 40, 217, 0.22);
        }

        .brand h1 {
            margin: 0 0 7px;
            color: #2e1065;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        .brand p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        .welcome {
            margin-bottom: 26px;
        }

        .welcome h2 {
            margin: 0 0 8px;
            color: #111827;
            font-size: 22px;
            font-weight: 700;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            background: #ffffff;
            color: #111827;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input::placeholder {
            color: #9ca3af;
        }

        input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 4px rgba(109, 40, 217, 0.10);
        }

        .error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 13px 14px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            line-height: 1.5;
        }

        button {
            width: 100%;
            margin-top: 5px;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 7px 16px rgba(109, 40, 217, 0.18);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(109, 40, 217, 0.25);
        }

        button:active {
            transform: translateY(0);
        }

        .footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .login-container {
                padding: 30px 23px;
                border-radius: 16px;
            }

            .brand h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">
        <header class="brand">
            <div class="brand-icon">S</div>
            <h1>Stockify</h1>
            <p>INVENTORY &amp; SALES MANAGEMENT SYSTEM</p>
        </header>

        <section class="welcome">
            <h2>Selamat datang!</h2>
            <p>Silakan masuk untuk mengelola inventaris dan penjualan.</p>
        </section>

        @if ($errors->any())
            <div class="error-box">
                Email atau password tidak valid. Silakan periksa kembali.
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    autocomplete="username"
                    required
                    autofocus
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Masuk ke Stockify</button>
        </form>

        <footer class="footer">
            &copy; {{ date('Y') }} Stockify. All rights reserved.
        </footer>
    </main>
</body>
</html>