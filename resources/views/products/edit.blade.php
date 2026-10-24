<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #FAF8FF;
            color: #312E46;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 20px 6%;
            background: white;
            border-bottom: 1px solid #E9E2F7;
        }
        .brand { color: #6D28D9; font-size: 24px; font-weight: bold; }
        .brand small {
            display: block;
            margin-top: 5px;
            color: #817792;
            font-size: 11px;
            font-weight: normal;
        }
        main { width: 92%; max-width: 850px; margin: 35px auto; }
        .panel {
            padding: 30px;
            background: white;
            border: 1px solid #E9E2F7;
            border-radius: 18px;
            box-shadow: 0 8px 28px rgba(109, 40, 217, .06);
        }
        h1 { margin: 0 0 10px; font-size: 27px; }
        .muted { color: #817792; line-height: 1.6; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 25px;
        }
        .field.full { grid-column: 1 / -1; }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #DDD3F0;
            border-radius: 10px;
            background: #FFFEFF;
            color: #312E46;
            font: inherit;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px #EDE9FE;
        }
        textarea { min-height: 100px; resize: vertical; }
        .hint { margin-top: 6px; color: #817792; font-size: 12px; }
        .error { margin-top: 7px; color: #B91C1C; font-size: 13px; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 28px; }
        .btn {
            display: inline-block;
            padding: 12px 18px;
            border: 0;
            border-radius: 10px;
            background: #6D28D9;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover { background: #5B21B6; }
        .btn-secondary { background: #EDE9FE; color: #5B21B6; }
        .btn-secondary:hover { background: #DDD6FE; }
        @media (max-width: 600px) {
            header { padding: 18px 5%; }
            main { margin-top: 22px; }
            .panel { padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
        }
    </style>
</head>
<body>

<header>
    <div class="brand">
        Stockify
        <small>Inventory &amp; Sales Management System</small>
    </div>
    <a class="btn btn-secondary" href="{{ route('dashboard') }}">Dashboard</a>
</header>

<main>
    <section class="panel">
        <h1>Edit Produk</h1>
        <p class="muted">Perbarui informasi produk yang tersimpan di inventaris.</p>

        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field">
                    <label for="sku">SKU / Kode Produk *</label>
                    <input id="sku" name="sku" type="text" maxlength="50"
                           value="{{ old('sku', $product->sku) }}" required>
                    @error('sku') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="name">Nama Produk *</label>
                    <input id="name" name="name" type="text" maxlength="150"
                           value="{{ old('name', $product->name) }}" required>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field full">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id">
                        <option value="">-- Pilih kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="purchase_price">Harga Beli (Rp) *</label>
                    <input id="purchase_price" name="purchase_price" type="number"
                           min="0" step="0.01"
                           value="{{ old('purchase_price', $product->purchase_price) }}" required>
                    @error('purchase_price') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="selling_price">Harga Jual (Rp) *</label>
                    <input id="selling_price" name="selling_price" type="number"
                           min="0" step="0.01"
                           value="{{ old('selling_price', $product->selling_price) }}" required>
                    @error('selling_price') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="stock">Stok *</label>
                    <input id="stock" name="stock" type="number" min="0" step="1"
                           value="{{ old('stock', $product->stock) }}" required>
                    @error('stock') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="minimum_stock">Batas Stok Menipis *</label>
                    <input id="minimum_stock" name="minimum_stock" type="number" min="0" step="1"
                           value="{{ old('minimum_stock', $product->minimum_stock) }}" required>
                    @error('minimum_stock') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field full">
                    <label for="description">Deskripsi Produk</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="actions">
                <button class="btn" type="submit">Simpan Perubahan</button>
                <a class="btn btn-secondary" href="{{ route('products.index') }}">Kembali</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>