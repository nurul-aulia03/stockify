<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Stockify</title>

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
            max-width: 950px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-top: 22px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #39207812;
        }

        h1, h2 {
            color: #6639c6;
        }

        .back {
            color: #6639c6;
            text-decoration: none;
            font-weight: bold;
        }

        .info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
        }

        .label {
            color: #817994;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .value {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 550px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 10px;
            text-align: left;
            border-bottom: 1px solid #eeeaf7;
        }

        th {
            background: #faf8ff;
            color: #71658d;
            font-size: 13px;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #6639c6;
            margin-top: 22px;
        }

        .notes {
            color: #625b76;
            white-space: pre-line;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 17px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back" href="{{ route('orders.index') }}">
            ← Kembali ke Daftar Pesanan
        </a>

        <h1>Detail Pesanan</h1>

        <div class="card">
            <div class="info">
                <div>
                    <div class="label">Nomor Pesanan</div>
                    <div class="value">{{ $order->order_number }}</div>
                </div>

                <div>
                    <div class="label">Nama Customer</div>
                    <div class="value">
                        {{ $order->customer->name ?? 'Customer tidak ditemukan' }}
                    </div>
                </div>

                <div>
                    <div class="label">Email Customer</div>
                    <div class="value">
                        {{ $order->customer->email ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="label">Tanggal Pesanan</div>
                    <div class="value">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div>
                    <div class="label">Status Pesanan</div>
                    <div class="value">{{ ucfirst($order->status) }}</div>
                </div>
            </div>

            @if ($order->notes)
                <div style="margin-top: 20px;">
                    <div class="label">Catatan</div>
                    <div class="notes">{{ $order->notes }}</div>
                </div>
            @endif
        </div>

        <div class="card">
            <h2>Barang yang Dipesan</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>SKU</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    Rp{{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada detail barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="total">
                Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
        </div>
    </div>
</body>
</html>