<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Baru | Stockify</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5fc;
            color: #302747;
        }

        .container { max-width: 720px; margin: auto; }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 5px 20px #38245c0b;
        }

        h1 { color: #6841a5; margin-top: 0; }
        p { color: #81788f; }

        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: 600;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2d9ef;
            border-radius: 10px;
            font: inherit;
            background: white;
        }

        input:focus, select:focus, textarea:focus {
            outline: 2px solid #cbb6ef;
            border-color: #7950bd;
        }

        .button {
            display: inline-block;
            padding: 12px 18px;
            border: 0;
            border-radius: 10px;
            background: #7950bd;
            color: white;
            text-decoration: none;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .back { background: #f0eafa; color: #6841a5; }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .error {
            color: #b42318;
            font-size: 13px;
            margin-top: 6px;
        }

        .hint {
            margin-top: 8px;
            font-size: 13px;
            color: #81788f;
        }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Penjualan Baru</h1>
        <p>Isi data transaksi penjualan produk.</p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <label for="product_id">Produk</label>
            <select name="product_id" id="product_id" required>
                <option value="">Pilih produk</option>
                @foreach ($products as $product)
                    <option
                        value="{{ $product->id }}"
                        data-price="{{ $product->selling_price }}"
                        data-stock="{{ $product->stock }}"
                        @selected(old('product_id') == $product->id)
                    >
                        {{ $product->name }}
                        — Stok: {{ $product->stock }}
                    </option>
                @endforeach
            </select>

            <div class="hint" id="product-info">Pilih produk untuk melihat harga dan stok.</div>

            <label for="quantity">Jumlah Terjual</label>
            <input
                type="number"
                name="quantity"
                id="quantity"
                min="1"
                value="{{ old('quantity', 1) }}"
                required
            >

            <label for="customer_name">Nama Pelanggan</label>
            <input
                type="text"
                name="customer_name"
                id="customer_name"
                maxlength="150"
                value="{{ old('customer_name') }}"
                placeholder="Contoh: Pelanggan Umum"
            >

            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Cash" @selected(old('payment_method', 'Cash') === 'Cash')>Tunai</option>
                <option value="Transfer" @selected(old('payment_method') === 'Transfer')>Transfer</option>
                <option value="QRIS" @selected(old('payment_method') === 'QRIS')>QRIS</option>
            </select>

            <label for="notes">Catatan</label>
            <textarea
                name="notes"
                id="notes"
                rows="3"
                placeholder="Catatan tambahan (opsional)"
            >{{ old('notes') }}</textarea>

            <div class="hint" id="total-info">Perkiraan total: Rp 0</div>

            <div class="actions">
                <a href="{{ route('sales.index') }}" class="button back">Kembali</a>
                <button type="submit" class="button">Simpan Penjualan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const productInfo = document.getElementById('product-info');
    const totalInfo = document.getElementById('total-info');

    function updateTotal() {
        const option = productSelect.options[productSelect.selectedIndex];
        const price = Number(option.dataset.price || 0);
        const stock = Number(option.dataset.stock || 0);
        const quantity = Number(quantityInput.value || 0);
        const formatter = new Intl.NumberFormat('id-ID');

        if (!option.value) {
            productInfo.textContent = 'Pilih produk untuk melihat harga dan stok.';
            totalInfo.textContent = 'Perkiraan total: Rp 0';
            quantityInput.removeAttribute('max');
            return;
        }

        productInfo.textContent =
            'Harga satuan: Rp ' + formatter.format(price) +
            ' | Stok tersedia: ' + stock;

        quantityInput.max = stock;

        totalInfo.textContent =
            'Perkiraan total: Rp ' + formatter.format(price * quantity);

        if (quantity > stock) {
            totalInfo.textContent += ' — Jumlah melebihi stok tersedia!';
        }
    }

    productSelect.addEventListener('change', updateTotal);
    quantityInput.addEventListener('input', updateTotal);

    updateTotal();
</script>
</body>
</html>