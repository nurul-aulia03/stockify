<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | Stockify</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f7f5ff;
            color: #292344;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1050px;
            margin: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            color: #6639c6;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #77718b;
            margin-top: 0;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        nav a {
            text-decoration: none;
            color: #6639c6;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #39207812;
        }

        .alert {
            padding: 13px 16px;
            margin-bottom: 18px;
            border-radius: 10px;
        }

        .success {
            background: #e7f8ee;
            color: #187343;
        }

        .error {
            background: #fff0f0;
            color: #b42318;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #eeeaf7;
        }

        th {
            color: #71658d;
            background: #faf8ff;
            font-size: 13px;
        }

        input[type="number"] {
            width: 75px;
            padding: 8px;
            border: 1px solid #ddd4f4;
            border-radius: 8px;
        }

        button {
            border: 0;
            border-radius: 8px;
            padding: 9px 12px;
            cursor: pointer;
            font-weight: bold;
        }

        .update {
            background: #eee8ff;
            color: #6639c6;
        }

        .remove {
            background: #fff0f0;
            color: #b42318;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 24px;
        }

        .total-label {
            color: #77718b;
            margin-bottom: 5px;
        }

        .total {
            color: #6639c6;
            font-size: 25px;
            font-weight: bold;
        }

        .checkout {
            background: #7045ce;
            color: white;
            padding: 13px 20px;
            font-size: 15px;
        }

        .continue {
            display: inline-block;
            margin-top: 20px;
            color: #6639c6;
            text-decoration: none;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 35px 10px;
            color: #77718b;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        form {
            margin: 0;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 13px;
            }

            .summary {
                align-items: stretch;
                flex-direction: column;
            }

            .checkout {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div>
                <h1>Keranjang Belanja</h1>
                <p class="subtitle">Periksa produk pilihanmu sebelum checkout.</p>
            </div>

            <nav>
                <a href="{{ route('customer.dashboard') }}">Katalog Produk</a>
                <a href="{{ route('customer.cart') }}">Keranjang</a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Keluar
                </a>
            </nav>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </header>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->has('cart'))
            <div class="alert error">{{ $errors->first('cart') }}</div>
        @endif

        @if ($errors->any() && !$errors->has('cart'))
            <div class="alert error">
                Periksa kembali jumlah produk yang kamu masukkan.
            </div>
        @endif

        <div class="card">
            @if (count($items) > 0)
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item['product']->name }}</strong>
                                        <br>
                                        <small>{{ $item['product']->sku }}</small>
                                    </td>

                                    <td>
                                        Rp{{ number_format($item['product']->selling_price, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <form action="{{ route('customer.cart.update', $item['product']->id) }}"
                                              method="POST"
                                              class="actions">
                                            @csrf
                                            @method('PATCH')

                                            <input type="number"
                                                   name="quantity"
                                                   value="{{ $item['quantity'] }}"
                                                   min="1"
                                                   max="{{ $item['product']->stock }}"
                                                   required>

                                            <button type="submit" class="update">Ubah</button>
                                        </form>
                                    </td>

                                    <td>
                                        <strong>
                                            Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </strong>
                                    </td>

                                    <td>
                                        <form action="{{ route('customer.cart.remove', $item['product']->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="remove">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="summary">
                    <div>
                        <div class="total-label">Total Belanja</div>
                        <div class="total">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </div>
                    </div>

                    <form action="{{ route('customer.cart.checkout') }}"
                          method="POST">
                        @csrf
                        <button type="submit" class="checkout">
                            Checkout Sekarang →
                        </button>
                    </form>
                </div>
            @else
                <div class="empty">
                    <h2>Keranjangmu masih kosong</h2>
                    <p>Yuk, pilih produk yang kamu butuhkan.</p>
                </div>
            @endif

            <a class="continue" href="{{ route('customer.dashboard') }}">
                ← Lanjut Belanja
            </a>
        </div>
    </div>
</body>
</html>