<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian - Stockify</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f7f5fc;
            color: #30234a;
        }

        .container { max-width: 850px; margin: auto; }
        h1 { color: #4c1d95; margin-bottom: 8px; }
        .subtitle { color: #777087; }

        .card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #35205b0b;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .field { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd6ee;
            border-radius: 9px;
            font: inherit;
            background: white;
        }

        .button {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 9px;
            background: #6d28d9;
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .button-light {
            background: #ede9fe;
            color: #5b21b6;
        }

        .error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 6px;
        }

        .notice {
            padding: 14px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #f5f3ff;
            color: #5b21b6;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .grid { grid-template-columns: 1fr; gap: 0; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>＋ Tambah Pembelian</h1>
        <p class="subtitle">
            Catat barang masuk dari pemasok ke inventaris Stockify.
        </p>

        <div class="card">
            <div class="notice">
                 Lengkapi data berikut. Setelah transaksi berhasil
                disimpan, stok produk akan bertambah otomatis.
            </div>

            @if ($errors->any())
                <div class="notice" style="background:#fee2e2;color:#991b1b;">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($suppliers->isEmpty())
                <div class="notice">
                    Belum ada data pemasok. Tambahkan pemasok terlebih dahulu
                    sebelum mencatat pembelian.
                </div>
            @endif

            @if ($products->isEmpty())
                <div class="notice">
                    Belum ada produk aktif. Tambahkan atau aktifkan produk
                    terlebih dahulu sebelum mencatat pembelian.
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <div class="grid">
                    <div class="field">
                        <label for="supplier_id">Pemasok *</label>
                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">-- Pilih pemasok --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    @selected(old('supplier_id') == $supplier->id)>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="purchase_date">Tanggal Pembelian *</label>
                        <input type="date" id="purchase_date"
                            name="purchase_date"
                            value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                            required>
                        @error('purchase_date')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="product_id">Produk *</label>
                        <select id="product_id" name="product_id" required>
                            <option value="">-- Pilih produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    data-price="{{ $product->purchase_price }}"
                                    @selected(old('product_id') == $product->id)>
                                    {{ $product->name }} ({{ $product->sku }})
                                    — Stok: {{ $product->stock }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="quantity">Jumlah Barang *</label>
                        <input type="number" id="quantity" name="quantity"
                            min="1" step="1" value="{{ old('quantity', 1) }}"
                            placeholder="Contoh: 10" required>
                        @error('quantity')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="unit_price">Harga Beli per Barang (Rp) *</label>
                        <input type="number" id="unit_price" name="unit_price"
                            min="0" step="0.01"
                            value="{{ old('unit_price') }}"
                            placeholder="Pilih produk terlebih dahulu" required>
                        @error('unit_price')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="notes">Catatan</label>
                    <textarea id="notes" name="notes" rows="3"
                        placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="notice">
                    <strong>Perkiraan total:</strong>
                    <span id="total">Rp0</span>
                </div>

                <div class="actions">
                    <a href="{{ route('purchases.index') }}"
                        class="button button-light">← Kembali</a>

                    <button type="submit" class="button"
                        @disabled($suppliers->isEmpty() || $products->isEmpty())>
                        Simpan Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const productSelect = document.getElementById('product_id');
        const priceInput = document.getElementById('unit_price');
        const quantityInput = document.getElementById('quantity');
        const totalDisplay = document.getElementById('total');

        function updateTotal() {
            const price = Number(priceInput.value) || 0;
            const quantity = Number(quantityInput.value) || 0;

            totalDisplay.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(price * quantity);
        }

        productSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (selected.dataset.price !== undefined) {
                priceInput.value = selected.dataset.price;
            }
            updateTotal();
        });

        priceInput.addEventListener('input', updateTotal);
        quantityInput.addEventListener('input', updateTotal);

        updateTotal();
    </script>
</body>
</html>