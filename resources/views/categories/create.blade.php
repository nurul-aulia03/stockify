<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori | Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #172033;
        }
        header {
            padding: 20px 6%;
            background: white;
            border-bottom: 1px solid #e2e8f0;
        }
        .brand { font-size: 24px; font-weight: bold; color: #2563eb; }
        .brand small {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 11px;
            font-weight: normal;
        }
        main {
            width: 90%;
            max-width: 720px;
            margin: 35px auto;
        }
        .panel {
            padding: 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }
        h1 { margin-top: 0; font-size: 26px; }
        .muted { color: #64748b; line-height: 1.6; }
        label {
            display: block;
            margin: 20px 0 8px;
            font-weight: bold;
            font-size: 14px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
        }
        textarea { min-height: 120px; resize: vertical; }
        .error {
            margin-top: 7px;
            color: #b91c1c;
            font-size: 13px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }
        .btn {
            display: inline-block;
            padding: 12px 17px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-secondary { background: #e2e8f0; color: #334155; }
    </style>
</head>
<body>
<header>
    <div class="brand">
        Stockify
        <small>Inventory &amp; Sales Management System</small>
    </div>
</header>

<main>
    <section class="panel">
        <h1>Tambah Kategori</h1>
        <p class="muted">Isi informasi kategori produk yang ingin ditambahkan.</p>

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <label for="name">Nama Kategori *</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                maxlength="100"
                placeholder="Contoh: Elektronik"
                required
            >
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                placeholder="Keterangan kategori (opsional)"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="actions">
                <button class="btn" type="submit">Simpan Kategori</button>
                <a class="btn btn-secondary" href="{{ route('categories.index') }}">Kembali</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>