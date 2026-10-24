<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasok - Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f7f5ff;
            color: #30264a;
        }
        .container { max-width: 760px; margin: auto; }
        .card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 5px 25px #35205b0d;
        }
        h1 { color: #6538b8; margin-top: 0; }
        .subtitle { color: #817795; margin-bottom: 25px; }
        .field { margin-bottom: 18px; }
        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e1d9f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
        }
        input:focus, textarea:focus {
            outline: 2px solid #c8b4f4;
            border-color: #7546c8;
        }
        textarea { resize: vertical; }
        .hint { color: #9185a5; font-size: 12px; margin-top: 6px; }
        .error { color: #c0395b; font-size: 13px; margin-top: 6px; }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }
        .button {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            background: #7546c8;
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .secondary { background: #eee7ff; color: #6538b8; }
        .required { color: #c0395b; }
        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Tambah Pemasok</h1>
        <p class="subtitle">Lengkapi informasi pemasok untuk kebutuhan inventaris.</p>

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name">Nama Pemasok <span class="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: PT Sumber Elektronik"
                    required
                >
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="contact_person">Nama Kontak</label>
                <input
                    type="text"
                    id="contact_person"
                    name="contact_person"
                    value="{{ old('contact_person') }}"
                    placeholder="Nama orang yang bisa dihubungi"
                >
                @error('contact_person')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="phone">Nomor Telepon</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Contoh: 081234567890"
                >
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="pemasok@email.com"
                >
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="address">Alamat</label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    placeholder="Alamat pemasok"
                >{{ old('address') }}</textarea>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="notes">Catatan</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    placeholder="Catatan tambahan jika ada"
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="button">Simpan Pemasok</button>
                <a href="{{ route('suppliers.index') }}" class="button secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>