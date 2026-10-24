<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk | Stockify</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5ff;
            color: #29243b;
        }

        .container { max-width: 1200px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        h1 { margin: 0 0 8px; }
        p { color: #77718b; line-height: 1.5; }
        .header p { margin-bottom: 0; }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        button, .btn {
            padding: 11px 16px;
            border: none;
            border-radius: 9px;
            background: #7048e8;
            color: white;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            font-family: inherit;
        }

        button:hover, .btn:hover { opacity: .88; }

        .summary {
            background: white;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px #30205a0b;
        }

        .summary strong { color: #7048e8; }
        .section-title { margin: 0 0 18px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(245px, 1fr));
            gap: 20px;
        }

        .card {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 20px #30205a0b;
            transition: transform .2s, box-shadow .2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px #30205a14;
        }

        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 130px;
            background: #eee8ff;
            border-radius: 10px;
            font-size: 20px;
            color: #7048e8;
            margin-bottom: 14px;
        }

        .sku { font-size: 12px; color: #77718b; margin: 0 0 8px; }

        .card h3 {
            margin: 4px 0 10px;
            min-height: 48px;
            line-height: 1.4;
        }

        .price {
            color: #7048e8;
            font-size: 21px;
            font-weight: 700;
            margin: 4px 0 12px;
        }

        .stock {
            display: inline-block;
            align-self: flex-start;
            padding: 6px 10px;
            border-radius: 20px;
            background: #e2f8e9;
            color: #18743b;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .stock.empty-stock {
            background: #ffe5e5;
            color: #b42318;
        }

        .buy-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 4px 0 16px;
        }

        .buy-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd2f5;
            border-radius: 8px;
            font-size: 14px;
        }

        .buy-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .buy-buttons button {
            width: 100%;
            min-height: 42px;
            font-weight: 600;
        }

        .btn-cart {
            background: #eee8ff;
            color: #7048e8;
        }

        .btn-checkout {
            background: #7048e8;
            color: white;
        }

        .details {
            margin-top: auto;
            border-top: 1px solid #f0edf8;
            padding-top: 14px;
        }

        .details summary {
            cursor: pointer;
            color: #7048e8;
            font-weight: 600;
            font-size: 14px;
        }

        .details p { font-size: 13px; margin-bottom: 0; }

        .message {
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        .success { background: #e2f8e9; color: #18743b; }
        .error { background: #ffe5e5; color: #b42318; }

        .empty {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            color: #77718b;
        }

        footer {
            text-align: center;
            color: #8b849f;
            font-size: 12px;
            margin-top: 35px;
        }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Stockify</h1>
            <p>
                Halo, {{ auth()->user()->name }}!
                Temukan produk favoritmu dan belanja dengan mudah.
            </p>
        </div>

        <div class="actions">
            <a href="{{ route('customer.cart') }}" class="btn">
                Keranjang
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="summary">
        <strong>Katalog Produk Stockify</strong>
        <p>Pilih produk untuk dimasukkan ke keranjang atau langsung checkout.</p>
        <span>Total produk: <strong>{{ $products->count() }}</strong></span>
    </div>

    @if (session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="message error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <h2 class="section-title">Pilihan Produk</h2>

    @if ($products->isEmpty())
        <div class="empty">
            <h3>Belum ada produk tersedia</h3>
            <p>Produk akan muncul di sini setelah tersedia di inventaris.</p>
        </div>
    @else
        <div class="grid">
            @foreach ($products as $product)
                <div class="card">
                    <div class="icon">Produk</div>

                    <p class="sku">SKU: {{ $product->sku }}</p>
                    <h3>{{ $product->name }}</h3>

                    <p class="price">
                        Rp{{ number_format($product->selling_price ?? 0, 0, ',', '.') }}
                    </p>

                    @if ($product->stock > 0 && $product->is_active)
                        <span class="stock">
                            Stok tersedia: {{ $product->stock }} unit
                        </span>

                        <form class="buy-form"
                              action="{{ route('customer.cart.add', $product->id) }}"
                              method="POST">
                            @csrf

                            <label for="quantity-{{ $product->id }}">
                                Jumlah pembelian
                            </label>

                            <input id="quantity-{{ $product->id }}"
                                   type="number"
                                   name="quantity"
                                   value="1"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   required>

                            <div class="buy-buttons">
                                <button class="btn-cart" type="submit">
                                    Tambah ke Keranjang
                                </button>

                                <button class="btn-checkout"
                                        type="submit"
                                        formaction="{{ route('customer.checkout.direct', $product->id) }}"
                                        formmethod="POST">
                                    Checkout
                                </button>
                            </div>
                        </form>
                    @else
                        <span class="stock empty-stock">
                            Produk tidak tersedia
                        </span>
                    @endif

                    <details class="details">
                        <summary>Lihat Detail Produk</summary>
                        <p><strong>Nama:</strong> {{ $product->name }}</p>
                        <p><strong>Kode:</strong> {{ $product->sku }}</p>
                        <p><strong>Ketersediaan:</strong> {{ $product->stock }} unit</p>
                        <p>{{ $product->description ?: 'Tidak ada deskripsi produk.' }}</p>
                    </details>
                </div>
            @endforeach
        </div>
    @endif

    <footer>
        © {{ date('Y') }} Stockify — Inventory & Sales Management System
    </footer>

</div>
</body>
</html>