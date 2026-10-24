<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok | Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5ff;
            color: #30264a;
        }
        .container { max-width: 1200px; margin: auto; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 24px;
        }
        h1 { margin: 0 0 7px; font-size: 28px; }
        .subtitle { margin: 0; color: #817895; }
        .back {
            background: #6d43c1;
            color: white;
            padding: 11px 17px;
            text-decoration: none;
            border-radius: 10px;
        }
        .panel {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 22px #34205c0b;
            margin-bottom: 22px;
        }
        form { display: flex; gap: 10px; flex-wrap: wrap; }
        input {
            flex: 1;
            min-width: 200px;
            padding: 12px 14px;
            border: 1px solid #e4def2;
            border-radius: 9px;
            font-size: 14px;
        }
        button {
            border: 0;
            background: #7950cf;
            color: white;
            padding: 12px 19px;
            border-radius: 9px;
            cursor: pointer;
        }
        .reset { color: #7653b7; text-decoration: none; align-self: center; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 850px; }
        th {
            background: #f4efff;
            color: #62439c;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        th, td {
            padding: 15px 12px;
            border-bottom: 1px solid #f0edf6;
        }
        td { font-size: 14px; }
        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #eee6ff;
            color: #7043bd;
            font-size: 12px;
            font-weight: 600;
        }
        .qty { font-weight: 700; }
        .empty { text-align: center; color: #817895; padding: 35px; }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
            color: #817895;
            font-size: 13px;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 7px;
            margin: 2px;
            text-decoration: none;
            color: #7043bd;
            background: #f4efff;
        }
        .pagination span[aria-current="page"] {
            background: #7043bd;
            color: white;
        }
        @media (max-width: 600px) {
            body { padding: 16px; }
            .panel { padding: 14px; }
            h1 { font-size: 23px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>↻ Riwayat Stok</h1>
            <p class="subtitle">Pantau setiap perubahan stok produk di Stockify.</p>
        </div>
        <a class="back" href="{{ route('dashboard') }}">← Dashboard</a>
    </div>

    <div class="panel">
        <form method="GET" action="{{ route('stock-movements.index') }}">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari produk, SKU, jenis perubahan, atau pengguna..."
            >
            <button type="submit">Cari</button>
            @if($search)
                <a class="reset" href="{{ route('stock-movements.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Pengguna</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>
                            <strong>{{ $movement->product?->name ?? 'Produk dihapus' }}</strong><br>
                            <small>{{ $movement->product?->sku ?? '-' }}</small>
                        </td>
                        <td><span class="badge">{{ $movement->movement_type }}</span></td>
                        <td class="qty">{{ $movement->quantity }}</td>
                        <td>{{ $movement->stock_before }}</td>
                        <td>{{ $movement->stock_after }}</td>
                        <td>{{ $movement->user?->name ?? '-' }}</td>
                        <td>{{ $movement->notes ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            @if($search)
                                Tidak ada riwayat stok yang cocok dengan "{{ $search }}".
                            @else
                                Belum ada riwayat perubahan stok.
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <span>Menampilkan {{ $movements->count() }} data pada halaman ini.</span>
            <div class="pagination">{{ $movements->links() }}</div>
        </div>
    </div>
</div>
</body>
</html>