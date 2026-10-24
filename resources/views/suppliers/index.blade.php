<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemasok - Stockify</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f7f5ff;
            color: #30264a;
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

        h1 { margin: 0 0 8px; color: #6538b8; }
        p { color: #817795; }

        .button {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 10px;
            background: #7546c8;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .secondary { background: #eee7ff; color: #6538b8; }

        .card {
            background: white;
            padding: 22px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #35205b0d;
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .search-input {
            flex: 1;
            min-width: 220px;
            padding: 12px 14px;
            border: 1px solid #ded3f5;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        .search-input:focus {
            border-color: #7546c8;
            box-shadow: 0 0 0 3px #7546c81a;
        }

        .result-info {
            margin-bottom: 15px;
            font-size: 13px;
            color: #817795;
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

        th { color: #796b91; font-size: 13px; }
        td { font-size: 14px; }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #e7f9ee;
            color: #247747;
            font-size: 12px;
        }

        .inactive {
            background: #f3eff8;
            color: #817795;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #817795;
        }

        .success {
            background: #e7f9ee;
            color: #247747;
            padding: 13px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .pagination { margin-top: 20px; }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 15px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Data Pemasok</h1>
            <p>Kelola informasi pemasok produk Stockify.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="button secondary">Dashboard</a>
            <a href="{{ route('suppliers.create') }}" class="button">+ Tambah Pemasok</a>
        </div>
    </div>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <form action="{{ route('suppliers.index') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari nama, kontak, telepon, atau email pemasok..."
                value="{{ $search ?? '' }}"
            >

            <button type="submit" class="button">Cari</button>
            <a href="{{ route('suppliers.index') }}" class="button secondary">Reset</a>
        </form>

        <div class="result-info">
            @if (!empty($search))
                Hasil pencarian untuk "<strong>{{ $search }}</strong>":
                {{ $suppliers->total() }} pemasok ditemukan.
            @else
                Total data pemasok: {{ $suppliers->total() }}.
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pemasok</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $supplier->name }}</strong></td>
                        <td>{{ $supplier->contact_person ?: '-' }}</td>
                        <td>{{ $supplier->phone ?: '-' }}</td>
                        <td>{{ $supplier->email ?: '-' }}</td>
                        <td>
                            @if ($supplier->is_active)
                                <span class="status">Aktif</span>
                            @else
                                <span class="status inactive">Tidak aktif</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            @if (!empty($search))
                                Pemasok yang cocok tidak ditemukan. Coba kata kunci lain.
                            @else
                                Belum ada data pemasok. Klik "Tambah Pemasok" untuk memulai.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
</body>
</html>