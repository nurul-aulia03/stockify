<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan | Stockify</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5fc;
            color: #302747;
        }

        .container { max-width: 1100px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 { margin: 0 0 8px; color: #6841a5; }
        p { margin: 0; color: #81788f; }

        .button {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            background: #7950bd;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .back, .reset {
            background: white;
            color: #6841a5;
            border: 1px solid #e5dcf3;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #38245c0b;
            overflow-x: auto;
        }

        .success {
            padding: 13px 16px;
            margin-bottom: 20px;
            background: #e8f8ef;
            color: #217747;
            border-radius: 10px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            min-width: 220px;
            padding: 12px 15px;
            border: 1px solid #e3d9f2;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        .search-input:focus {
            border-color: #956bd0;
            box-shadow: 0 0 0 3px #956bd01a;
        }

        .result-info {
            margin-bottom: 16px;
            font-size: 13px;
            color: #81788f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #eeeaf5;
        }

        th {
            color: #796b90;
            font-size: 13px;
            background: #faf8fd;
        }

        .empty {
            text-align: center;
            padding: 40px 15px;
            color: #8b8298;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            background: #e8f8ef;
            color: #217747;
            border-radius: 20px;
            font-size: 12px;
        }

        .pagination { margin-top: 20px; }

        @media (max-width: 600px) {
            body { padding: 18px; }
            .card { padding: 12px; }
            .search-form > * { width: 100%; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Penjualan</h1>
            <p>Kelola dan pantau transaksi penjualan produk.</p>
        </div>

        <div>
            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('staff.dashboard') }}"
               class="button back">Dashboard</a>
            <a href="{{ route('sales.create') }}" class="button">+ Penjualan Baru</a>
        </div>
    </div>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <form action="{{ route('sales.index') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari nomor transaksi atau nama pelanggan..."
                value="{{ $search ?? '' }}"
            >
            <button type="submit" class="button">Cari</button>
            <a href="{{ route('sales.index') }}" class="button reset">Reset</a>
        </form>

        <div class="result-info">
            Menampilkan {{ $sales->count() }} dari {{ $sales->total() }} transaksi penjualan.
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nomor Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td>{{ $sales->firstItem() + $loop->index }}</td>
                        <td>{{ $sale->sale_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                        <td>{{ $sale->customer_name ?: 'Pelanggan Umum' }}</td>
                        <td>Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</td>
                        <td><span class="status">{{ ucfirst($sale->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            @if ($search)
                                Tidak ada transaksi yang cocok dengan "{{ $search }}".
                            @else
                                Belum ada transaksi penjualan.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($sales->hasPages())
            <div class="pagination">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>