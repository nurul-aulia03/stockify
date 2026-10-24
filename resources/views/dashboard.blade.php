<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Stockify</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #F7F5FC;
            color: #302747;
        }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            padding: 26px 16px;
            background: #4C1D95;
            color: white;
        }

        .brand {
            padding: 0 12px 22px;
            font-size: 27px;
            font-weight: 800;
        }

        .brand small {
            display: block;
            margin-top: 6px;
            color: #DDD6FE;
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 1px;
        }

        .nav-title {
            margin: 25px 12px 12px;
            color: #C4B5FD;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link {
            display: block;
            width: 100%;
            margin-bottom: 6px;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            color: #EDE9FE;
            background: transparent;
            text-decoration: none;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background: #7C3AED;
        }

        .main { flex: 1; min-width: 0; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 20px 30px;
            background: white;
            border-bottom: 1px solid #EAE5F5;
        }

        .topbar h2 { font-size: 20px; }

        .user {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            color: #6D28D9;
            background: #F3E8FF;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
        }

        .logout {
            border: 0;
            color: #6D28D9;
            background: transparent;
            font-weight: 700;
            cursor: pointer;
        }

        .content { padding: 30px; }
        .welcome { margin-bottom: 25px; }
        .welcome h1 { margin-bottom: 8px; font-size: 27px; }

        .muted {
            color: #89839D;
            font-size: 13px;
            line-height: 1.7;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            min-width: 0;
            padding: 21px;
            border: 1px solid #EEE8F8;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 16px #43237009;
        }

        .stat-label { color: #89839D; font-size: 13px; }
        .stat-number {
            margin-top: 14px;
            color: #5B21B6;
            font-size: 25px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .stat-icon {
            width: 38px;
            height: 5px;
            margin-bottom: 16px;
            border-radius: 5px;
            background: #C4B5FD;
        }

        .charts {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(250px, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .section-heading { margin-bottom: 15px; font-size: 17px; }
        .chart-area { position: relative; height: 270px; margin-top: 15px; }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 18px 0;
        }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            border-radius: 9px;
            color: white;
            background: #6D28D9;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .btn:hover { background: #5B21B6; }

        .table-card { margin-bottom: 22px; }
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 450px;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 14px 10px;
            border-bottom: 1px solid #F0ECF7;
            text-align: left;
        }

        th {
            color: #89839D;
            background: #FCFBFE;
            font-weight: 600;
        }

        .pill {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            color: #6D28D9;
            background: #F3E8FF;
            font-size: 11px;
        }

        .empty {
            padding: 20px 0;
            color: #89839D;
            font-size: 13px;
        }

        footer {
            padding: 22px;
            color: #9891A9;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .charts { grid-template-columns: 1fr; }
        }

        @media (max-width: 700px) {
            .layout { display: block; }
            .sidebar { width: 100%; }
            .topbar { padding: 18px; }
            .content { padding: 20px 15px; }
            .welcome h1 { font-size: 23px; }
        }

        @media (max-width: 420px) {
            .stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">
            Stockify
            <small>INVENTORY &amp; SALES SYSTEM</small>
        </div>

        <div class="nav-title">Menu Utama</div>
        <a class="nav-link active" href="{{ route('dashboard') }}">▦ &nbsp; Dashboard</a>
        <a class="nav-link" href="{{ route('categories.index') }}">▤ &nbsp; Kategori Produk</a>
        <a class="nav-link" href="{{ route('products.index') }}">▣ &nbsp; Data Produk</a>
        <a class="nav-link" href="{{ route('suppliers.index') }}">♧ &nbsp; Pemasok</a>

        
        <div class="nav-title">Transaksi</div>
        <a class="nav-link" href="{{ route('purchases.index') }}">＋ &nbsp; Pembelian</a>
        <a class="nav-link" href="{{ route('sales.index') }}">↗ &nbsp; Penjualan</a>
        <a class="nav-link" href="{{ url('/stock-movements') }}">↻ &nbsp; Riwayat Stok</a>
        <a class="nav-link" href="{{ route('reports.index') }}">▤ &nbsp; Laporan</a>


        <div class="nav-title">Lainnya</div>
        <a class="nav-link" href="{{ url('/users') }}">♙ &nbsp; Pengguna</a>

        <div class="nav-title">Akun</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link" type="submit">⇥ &nbsp; Keluar</button>
        </form>
    </aside>

    <div class="main">
        <header class="topbar">
            <h2>Dashboard</h2>
            <div class="user">
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit">Keluar</button>
                </form>
            </div>
        </header>

        <main class="content">
            <section class="welcome">
                <h1>Selamat datang, {{ auth()->user()->name }}! </h1>
                <p class="muted">Pantau inventaris dan aktivitas bisnis Stockify dari satu halaman.</p>
            </section>

            <section class="stats">
                <div class="card">
                    <div class="stat-icon"></div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-number">{{ number_format($totalProducts) }}</div>
                </div>
                <div class="card">
                    <div class="stat-icon"></div>
                    <div class="stat-label">Total Penjualan</div>
                    <div class="stat-number" style="font-size:21px">Rp{{ number_format($totalSales, 0, ',', '.') }}</div>
                </div>
                <div class="card">
                    <div class="stat-icon"></div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-number">{{ number_format($lowStock) }}</div>
                </div>
                <div class="card">
                    <div class="stat-icon"></div>
                    <div class="stat-label">Penjualan Hari Ini</div>
                    <div class="stat-number" style="font-size:21px">Rp{{ number_format($salesToday, 0, ',', '.') }}</div>
                </div>
            </section>

            <section class="charts">
                <div class="card">
                    <h3 class="section-heading">Grafik Penjualan 7 Hari</h3>
                    <p class="muted">Ringkasan nilai transaksi penjualan.</p>
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h3 class="section-heading">Akses Cepat</h3>
                    <p class="muted">Pilih fitur yang ingin kamu kelola.</p>
                    <div class="quick-links">
                        <a class="btn" href="{{ route('products.create') }}">+ Tambah Produk</a>
                        <a class="btn" href="{{ route('categories.create') }}">+ Tambah Kategori</a>
                        <a class="btn" href="{{ route('suppliers.create') }}">+ Tambah Pemasok</a>
                        <a class="btn" href="{{ route('purchases.create') }}">+ Pembelian</a>
                        <a class="btn" href="{{ route('sales.create') }}">+ Penjualan</a>
                    </div>
                    <p class="muted">Gunakan menu di sebelah kiri untuk membuka halaman pengelolaan.</p>
                </div>
            </section>

            <section class="card table-card">
                <h3 class="section-heading">Produk Terlaris</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Nama Produk</th><th>SKU</th><th>Jumlah Terjual</th></tr></thead>
                        <tbody>
                        @forelse ($bestSellingProducts as $item)
                            <tr>
                                <td>{{ $item->product?->name ?? 'Produk tidak tersedia' }}</td>
                                <td>{{ $item->product?->sku ?? '-' }}</td>
                                <td><span class="pill">{{ $item->total_quantity }} unit</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty">Belum ada data penjualan untuk ditampilkan.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card table-card">
                <h3 class="section-heading">Transaksi Penjualan Terbaru</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>No. Penjualan</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th></tr></thead>
                        <tbody>
                        @forelse ($recentSales as $sale)
                            <tr>
                                <td>{{ $sale->sale_number }}</td>
                                <td>{{ $sale->sale_date?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $sale->customer_name ?: 'Pelanggan Umum' }}</td>
                                <td>Rp{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty">Belum ada transaksi penjualan.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card table-card">
                <h3 class="section-heading">Pembelian Terbaru</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>No. Pembelian</th><th>Tanggal</th><th>Pemasok</th><th>Total</th></tr></thead>
                        <tbody>
                        @forelse ($recentPurchases as $purchase)
                            <tr>
                                <td>{{ $purchase->purchase_number }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $purchase->supplier?->name ?? '-' }}</td>
                                <td>Rp{{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty">Belum ada transaksi pembelian.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card table-card">
                <h3 class="section-heading">Aktivitas Pergerakan Stok</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Produk</th><th>Aktivitas</th><th>Jumlah</th><th>Sebelum</th><th>Sesudah</th></tr></thead>
                        <tbody>
                        @forelse ($recentMovements as $movement)
                            <tr>
                                <td>{{ $movement->product?->name ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $movement->movement_type)) }}</td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->stock_before }}</td>
                                <td>{{ $movement->stock_after }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty">Belum ada riwayat pergerakan stok.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <footer>© {{ date('Y') }} Stockify · Inventory &amp; Sales Management System</footer>
    </div>
</div>

<script>
    const salesLabels = @json($salesChart->pluck('label')->values());
    const salesValues = @json($salesChart->pluck('total')->values());

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: salesValues,
                borderColor: '#7C3AED',
                backgroundColor: 'rgba(124, 58, 237, 0.12)',
                fill: true,
                tension: 0.35,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#7C3AED'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp' + Number(value).toLocaleString('id-ID')
                    },
                    grid: { color: '#F0ECF7' }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
</body>
</html>