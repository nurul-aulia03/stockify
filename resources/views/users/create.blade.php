<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun | Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px 16px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5ff;
            color: #29243b;
        }
        .container { max-width: 650px; margin: 25px auto; }
        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px #30205a0b;
        }
        h1 { margin: 0 0 8px; font-size: 27px; }
        .subtitle { color: #77718b; margin-bottom: 25px; }
        label {
            display: block;
            margin: 17px 0 8px;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ded8ed;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }
        input:focus, select:focus {
            outline: 2px solid #c9baff;
            border-color: #7048e8;
        }
        .button {
            display: inline-block;
            padding: 12px 18px;
            background: #7048e8;
            color: white;
            border: none;
            border-radius: 9px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }
        .secondary { background: #eee9fa; color: #5835bd; }
        .actions { display: flex; gap: 10px; margin-top: 25px; }
        .errors {
            background: #fff0f0;
            color: #b42318;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 15px;
        }
        .hint { font-size: 12px; color: #77718b; margin-top: 6px; }
        @media (max-width: 500px) {
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Tambah Akun</h1>
        <p class="subtitle">Buat akun baru untuk Staff atau Customer Stockify.</p>

        @if ($errors->any())
            <div class="errors">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
            >

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required
            >

            <label for="role">Peran Akun</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Peran --</option>
                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
            <p class="hint">Admin tidak dibuat melalui form ini.</p>

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimal 8 karakter"
                minlength="8"
                required
            >

            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Ketik ulang password"
                minlength="8"
                required
            >

            <div class="actions">
                <button type="submit" class="button">Simpan Akun</button>
                <a href="{{ route('users.index') }}" class="button secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>