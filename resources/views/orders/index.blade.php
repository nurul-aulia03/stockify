<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan | Stockify</title>

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
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: #6639c6;
        }

        .subtitle {
            color: #77718b;
            margin: 0;
        }

        .back {
            color: #6639c6;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 20px #39207812;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
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

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #f0eaff;
            color: #6639c6;
            font-size: 12px;
        }

        .detail {
            display: inline-block;
            background: #7045ce;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            color: #77718b;
            padding: 35px;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Daftar Pesanan</h1>
                <p class="subtitle">
                    Pantau pesanan yang dibuat oleh customer Stockify.
                </p>
            </div>

            <a class="back" href="{{ url('/dashboard') }}">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>
                                {{ $order->customer->name ?? 'Customer tidak ditemukan' }}
                            </td>
                            <td>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="status">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a class="detail"
                                   href="{{ route('orders.show', $order->id) }}">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada pesanan customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>