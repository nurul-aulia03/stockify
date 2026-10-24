<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk | Stockify</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --primary: #6d4aff;
            --primary-dark: #5035c9;
            --primary-soft: #f1edff;
            --background: #f8f9fc;
            --white: #fff;
            --text: #25243a;
            --muted: #89899b;
            --border: #eeedf4;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a { color: inherit; text-decoration: none; }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 28px 18px;
            background: var(--white);
            border-right: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            border-bottom: 1px solid var(--border);
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 22px;
            font-weight: 800;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand-name span { color: var(--primary); }

        .brand-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 9px;
            letter-spacing: 1.4px;
        }

        .menu-label {
            margin: 29px 11px 12px;
            color: #a4a2b2;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            margin-bottom: 5px;
            border-radius: 10px;
            color: #77768b;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-number {
            width: 24px;
            color: #aaa7bb;
            font-size: 10px;
            font-weight: 800;
        }

        .nav-link.active .nav-number,
        .nav-link:hover .nav-number {
            color: var(--primary);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 17px 14px;
            border: 1px solid #e9e3ff;
            border-radius: 12px;
            background: #faf8ff;
        }

        .sidebar-bottom strong {
            display: block;
            font-size: 12px;
        }

        .sidebar-bottom p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 30px 38px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 30px;
        }

        .breadcrumb { color: var(--muted); font-size: 12px; }
        .breadcrumb strong { color: var(--text); }

        .account {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 800;
        }

        .account-info strong { display: block; font-size: 12px; }
        .account-info small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: -.8px;
        }

        .description {
            margin: 9px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 15px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: var(--primary);
            color: white;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover { background: var(--primary-dark); }

        .btn-secondary {
            border-color: var(--border);
            background: white;
            color: #625a77;
        }

        .btn-secondary:hover {
            border-color: #d7ccff;
            background: var(--primary-soft);
            color: var(--primary);
        }

        .btn-danger {
            background: #fff1f2;
            color: #be123c;
        }

        .btn-danger:hover {
            background: #ffe0e5;
            color: #9f1239;
        }

        .message {
            padding: 13px 15px;
            margin-bottom: 18px;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            background: #f0fdf4;
            color: #166534;
            font-size: 13px;
        }

        .message.error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .panel {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(50, 40, 90, .035);
        }

        .panel-heading {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h2 {
            margin: 0;
            font-size: 16px;
        }

        .panel-heading p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .search-box {
            display: flex;
            align-items: end;
            flex-wrap: wrap;
            gap: 10px;
            padding: 19px 24px;
            border-bottom: 1px solid var(--border);
            background: #fdfcff;
        }

        .search-field { flex: 1; min-width: 210px; }

        .search-field label {
            display: block;
            margin-bottom: 8px;
            color: #51496a;
            font-size: 12px;
            font-weight: 700;
        }

        .search-field input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #e5e1ef;
            border-radius: 9px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
        }

        .search-field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-soft);
        }

        .table-info {
            padding: 17px 24px;
            color: var(--muted);
            font-size: 12px;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th {
            padding: 14px 15px;
            background: #faf9fd;
            color: #777187;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .5px;
            text-align: left;
            text-transform: uppercase;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0eef5;
            font-size: 12px;
            vertical-align: middle;
        }

        tbody tr:hover { background: #fcfbff; }
        tbody tr:last-child td { border-bottom: none; }

        .product-name {
            color: var(--text);
            font-weight: 700;
        }

        .sku {
            display: inline-block;
            padding: 5px 8px;
            border: 1px solid #eeebf5;
            border-radius: 6px;
            background: #faf9fd;
            color: #72698a;
            font-size: 11px;
        }

        .stock-badge {
            display: inline-block;
            min-width: 35px;
            padding: 6px 9px;
            border-radius: 7px;
            background: #edfdf3;
            color: #16834a;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
        }

        .stock-badge.low {
            background: #fff5e8;
            color: #b96b12;
        }

        .actions { display: flex; gap: 6px; }
        .actions form { margin: 0; }
        .actions .btn { padding: 8px 10px; font-size: 11px; }

        .empty {
            padding: 38px 20px;
            color: var(--muted);
            text-align: center;
            white-space: normal;
            line-height: 1.8;
        }

        .pagination {
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            font-size: 12px;
        }

        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            color: #9997a8;
            font-size: 11px;
        }

        .logout {
            padding: 10px 14px;
            border: 1px solid #e8e5f0;
            border-radius: 9px;
            background: white;
            color: #625a77;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .logout:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        @media (max-width: 1050px) {
            .sidebar { width: 220px; }
            .main { padding: 25px; }
        }

        @media (max-width: 700px) {
            .layout { display: block; }
            .sidebar {
                width: 100%;
                padding: 18px;
            }
            .brand { padding-bottom: 18px; }
            .menu-label { margin-top: 20px; }
            .sidebar-bottom { margin-top: 20px; }
            .main { padding: 22px 16px; }
            .topbar { margin-bottom: 24px; }
            h1 { font-size: 24px; }
            .panel-heading, .search-box { padding: 17px; }
            .table-info { padding: 15px 17px; }
            .pagination { padding: 16px; }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">S</div>
            <div>
                <div class="brand-name">stock<span>ify</span></div>
                <div class="brand-subtitle">INVENTORY SYSTEM</div>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        @if (auth()->user()->role === 'staff')
            <a href="{{ route('staff.dashboard') }}" class="nav-link">
                <span class="nav-number">01</span> Dashboard
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span class="nav-number">01</span> Dashboard
            </a>
        @endif

        <a href="{{ route('categories.index') }}" class="nav-link">
            <span class="nav-number">02</span> Kategori Produk
        </a>

        <a href="{{ route('products.index') }}" class="nav-link active">
            <span class="nav-number">03</span> Data Produk
        </a>

        <a href="{{ route('suppliers.index') }}" class="nav-link">
            <span class="nav-number">04</span> Pemasok
        </a>

        <div class="menu-label">TRANSAKSI</div>

        <a href="{{ route('purchases.index') }}" class="nav-link">
            <span class="nav-number">05</span> Pembelian
        </a>

        <a href="{{ route('sales.index') }}" class="nav-link">
            <span class="nav-number">06</span> Penjualan
        </a>

        <a href="{{ route('stock-movements.index') }}" class="nav-link">
            <span class="nav-number">07</span> Riwayat Stok
        </a>

        @if (auth()->user()->role === 'admin')
            <div class="menu-label">LAINNYA</div>
            <a href="{{ route('users.index') }}" class="nav-link">
                <span class="nav-number">08</span> Pengguna
            </a>
        @endif

        <div class="sidebar-bottom">
            <strong>Stockify Inventory</strong>
            <p>Sistem pengelolaan persediaan dan transaksi barang dalam satu tempat.</p>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="breadcrumb">
                Halaman Utama / <strong>Data Produk</strong>
            </div>

            <div class="account">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="account-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ ucfirst(auth()->user()->role ?? 'Pengguna') }}</small>
                </div>
            </div>
        </header>

        <section class="page-heading">
            <div>
                <div class="eyebrow">MANAJEMEN INVENTARIS</div>
                <h1>Data Produk</h1>
                <p class="description">
                    Kelola barang, harga, kategori, dan stok inventaris.
                </p>
            </div>

            <a class="btn" href="{{ route('products.create') }}">
                + Tambah Produk
            </a>
        </section>

        @if (session('success'))
            <div class="message">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <section class="panel">
            <div class="panel-heading">
                <h2>Daftar Produk</h2>
                <p>Informasi produk yang tersimpan dalam sistem Stockify.</p>
            </div>

            <form method="GET" action="{{ route('products.index') }}"
                  class="search-box">
                <div class="search-field">
                    <label for="search">Cari berdasarkan nama atau SKU</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Masukkan nama produk atau SKU..."
                    >
                </div>

                <button type="submit" class="btn">Cari Produk</button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">Reset</a>
            </form>

            <div class="table-info">
                @if (!empty($search))
                    Hasil pencarian untuk "<strong>{{ $search }}</strong>" —
                    {{ $products->total() }} produk ditemukan.
                @else
                    Total {{ $products->total() }} produk terdaftar.
                @endif
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                <td><span class="sku">{{ $product->sku }}</span></td>
                                <td class="product-name">{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? 'Tanpa kategori' }}</td>
                                <td>Rp{{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="stock-badge {{ $product->stock <= 5 ? 'low' : '' }}">
                                        {{ number_format($product->stock, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-secondary"
                                           href="{{ route('products.edit', $product) }}">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('products.destroy', $product) }}"
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    @if (!empty($search))
                                        Produk tidak ditemukan. Coba kata kunci lain.
                                    @else
                                        Belum ada produk. Klik Tambah Produk untuk memulai.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        </section>

        <footer class="footer">
            <span>© {{ date('Y') }} Stockify. Inventory Management System.</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout">Keluar dari Akun</button>
            </form>
        </footer>
    </main>
</div>
</body>
</html>