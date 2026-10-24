<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian - Stockify</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f7f5fc;
            color: #30234a;
        }

        .container { max-width: 1100px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 { margin: 0 0 8px; color: #4c1d95; }
        .subtitle { margin: 0; color: #777087; }

        .button {
            display: inline-block;
            padding: 12px 17px;
            border-radius: 10px;
            background: #6d28d9;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .button:hover { background: #4c1d95; }

        .button-light {
            background: #ede9fe;
            color: #5b21b6;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #35205b0b;
            overflow-x: auto;
        }

        .notice {
            padding: 14px;
            margin-bottom: 18px;
            background: #f3e8ff;
            color: #5b21b6;
            border-radius: 10px;
        }

        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 22px 0 15px;
        }

        .search-input {
            flex: 1;
            min-width: 230px;
            padding: 12px 14px;
            border: 1px solid #ddd6fe;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
        }

        .search-input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px #7c3aed1a;
        }

        .result-info {
            color: #777087;
            font-size: 13px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            min-width: 650px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #eeeaf5;
        }

        th { background: #f5f3ff; color: #5b21b6; }

        .empty {
            padding: 35px;
            text-align: center;
            color: #817991;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
        }

        footer {
            margin-top: 25px;
            text-align: center;
            color: #928aa1;
            font-size: 13px;
        }

        .pagination { margin-top: 20px; }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1> Data Pembelian</h1>
                <p class="subtitle">
                    Kelola transaksi barang masuk Stockify.
                </p>
            </div>

            <div>
                <a href="{{ route('dashboard') }}" class="button button-light">
                    ← Dashboard
                </a>

                <a href="{{ route('purchases.create') }}" class="button">
                    + Tambah Pembelian
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="notice success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="notice error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <h2>Riwayat Pembelian</h2>
            <p class="subtitle">
                Daftar transaksi pembelian barang dari pemasok.
            </p>

            <form action="{{ route('purchases.index') }}" method="GET" class="search-form">
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Cari nomor pembelian atau nama pemasok..."
                    value="{{ $search ?? '' }}"
                >

                <button type="submit" class="button">Cari</button>

                <a href="{{ route('purchases.index') }}" class="button button-light">
                    Reset
                </a>
            </form>

            <div class="result-info">
                @if (!empty($search))
                    Hasil pencarian "<strong>{{ $search }}</strong>":
                    {{ $purchases->total() }} transaksi ditemukan.
                @else
                    Total transaksi pembelian: {{ $purchases->total() }}.
                @endif
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No. Pembelian</th>
                        <th>Tanggal</th>
                        <th>Pemasok</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->purchase_number }}</td>
                            <td>
                                {{ $purchase->purchase_date
                                    ? \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>{{ $purchase->supplier->name ?? '-' }}</td>
                            <td>
                                Rp{{ number_format((float) $purchase->total_amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="status">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                @if (!empty($search))
                                    Transaksi tidak ditemukan. Coba kata kunci lain.
                                @else
                                    Belum ada transaksi pembelian.
                                    <br><br>
                                    Klik tombol Tambah Pembelian untuk memulai.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $purchases->links() }}
            </div>
        </div>

        <footer>
            © 2026 Stockify · Inventory &amp; Sales Management System
        </footer>
    </div>
</body>
</html>