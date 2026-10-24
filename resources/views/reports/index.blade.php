<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | Stockify</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #F7F5FC;
            color: #302747;
        }

        .header {
            background: #4C1D95;
            color: white;
            padding: 24px 30px;
        }

        .header h1 { margin: 0 0 6px; font-size: 26px; }
        .header p { margin: 0; color: #DDD6FE; font-size: 13px; }

        .container { max-width: 1450px; margin: auto; padding: 28px; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .topbar h2 { margin: 0 0 6px; font-size: 23px; }
        .muted { color: #89839D; font-size: 13px; line-height: 1.6; }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 11px 15px;
            background: #6D28D9;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover { background: #5B21B6; }
        .btn-light { background: #EDE9FE; color: #5B21B6; }

        .card {
            padding: 22px;
            margin-bottom: 22px;
            background: white;
            border: 1px solid #EEE8F8;
            border-radius: 14px;
            box-shadow: 0 4px 16px #43237009;
        }

        .filters {
            display: flex;
            align-items: end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .field { display: flex; flex-direction: column; gap: 7px; }
        .field label { font-size: 12px; font-weight: 600; }

        input[type="date"] {
            padding: 10px;
            border: 1px solid #DDD6E8;
            border-radius: 8px;
            font: inherit;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .stat-label { color: #89839D; font-size: 13px; }
        .stat-value {
            margin-top: 12px;
            color: #5B21B6;
            font-size: 22px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .section-heading h3 { margin: 0; font-size: 18px; }
        .count { color: #6D28D9; font-size: 12px; font-weight: 700; }

        .table-wrap { overflow-x: auto; margin-top: 16px; }

        table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 13px 10px;
            text-align: left;
            border-bottom: 1px solid #F0ECF7;
        }

        th { color: #6D28D9; background: #F7F3FF; font-weight: 700; }
        .empty { padding: 24px; text-align: center; color: #89839D; }

        .safe { color: #15803D; font-weight: 700; }
        .low { color: #DC2626; font-weight: 700; }

        footer {
            padding: 15px;
            color: #89839D;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 850px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .container { padding: 16px; }
        }

        @media (max-width: 480px) {
            .stats { grid-template-columns: 1fr; }
        }

        @media print {
            body { background: white; }
            .header { background: white; color: black; padding: 0 0 20px; }
            .header p { color: #555; }
            .container { padding: 0; }
            .no-print, .filters-card { display: none !important; }
            .card { box-shadow: none; break-inside: avoid; }
            th { background: #EEE !important; color: black; }
            table { font-size: 10px; min-width: 0; }
            th, td { padding: 7px 5px; }
        }
    </style>
</head>
<body>

<header class="header">
    <h1>Stockify</h1>
    <p>LAPORAN INVENTARIS DAN TRANSAKSI</p>
</header>

<main class="container">

    <div class="topbar">
        <div>
            <h2>Laporan</h2>
            <p class="muted">Rekapitulasi penjualan, pembelian, dan persediaan produk.</p>
        </div>

        <div class="no-print">
            <a href="{{ route('dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
            <button type="button" class="btn" onclick="window.print()">Cetak / Simpan PDF</button>
        </div>
    </div>

    <section class="card filters-card">
        <h3 style="margin-top:0;">Filter Periode</h3>
        <p class="muted">Pilih tanggal untuk melihat transaksi pada periode tertentu.</p>

        <form method="GET" action="{{ route('reports.index') }}" class="filters">
            <div class="field">
                <label for="start_date">Tanggal Awal</label>
                <input type="date" id="start_date" name="start_date"
                       value="{{ $startDate }}" required>
            </div>

            <div class="field">
                <label for="end_date">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date"
                       value="{{ $endDate }}" required>
            </div>

            <button type="submit" class="btn">Tampilkan</button>
            <a href="{{ route('reports.index') }}" class="btn btn-light">Reset</a>
        </form>
    </section>

    <section class="stats">
        <div class="card">
            <div class="stat-label">Total Penjualan</div>
            <div class="stat-value">Rp{{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Total Pembelian</div>
            <div class="stat-value">Rp{{ number_format($totalPurchases, 0, ',', '.') }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Jumlah Produk</div>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Produk Stok Menipis</div>
            <div class="stat-value">{{ number_format($lowStockProducts->count()) }}</div>
        </div>
    </section>

    <section class="card">
        <div class="section-heading">
            <h3>Laporan Penjualan</h3>
            <span class="count">{{ $sales->count() }} transaksi</span>
        </div>
        <p class="muted">
            Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
            sampai {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}.
        </p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->sale_number }}</td>
                            <td>{{ $sale->sale_date?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $sale->customer_name ?: 'Pelanggan Umum' }}</td>
                            <td>Rp{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">Tidak ada penjualan pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($sales->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="4">Total Penjualan</th>
                            <th>Rp{{ number_format($totalSales, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>

    <section class="card">
        <div class="section-heading">
            <h3>Laporan Pembelian</h3>
            <span class="count">{{ $purchases->count() }} transaksi</span>
        </div>
        <p class="muted">Daftar pembelian barang dari pemasok.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Pembelian</th>
                        <th>Tanggal</th>
                        <th>Pemasok</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->purchase_number }}</td>
                            <td>{{ $purchase->purchase_date?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $purchase->supplier?->name ?? '-' }}</td>
                            <td>Rp{{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">Tidak ada pembelian pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($purchases->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="4">Total Pembelian</th>
                            <th>Rp{{ number_format($totalPurchases, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>

    <section class="card">
        <div class="section-heading">
            <h3>Laporan Stok Produk</h3>
            <span class="count">{{ $products->count() }} produk</span>
        </div>
        <p class="muted">Posisi persediaan produk saat ini.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Stok Tersedia</th>
                        <th>Stok Minimum</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->sku ?? '-' }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->minimum_stock }}</td>
                            <td>
                                @if ($product->stock <= $product->minimum_stock)
                                    <span class="low">Stok Menipis</span>
                                @else
                                    <span class="safe">Stok Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        Stockify — Laporan dibuat pada {{ now()->format('d/m/Y H:i') }}
    </footer>

</main>
</body>
</html>