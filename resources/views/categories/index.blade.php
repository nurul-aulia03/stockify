<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk | Stockify</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --purple: #6d28d9;
            --purple-dark: #5b21b6;
            --purple-light: #f3e8ff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --sidebar-width: 250px;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f8f7fc;
            color: var(--text);
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            padding: 28px 18px;
            background: linear-gradient(180deg, #4c1d95, #2e1065);
            color: white;
            overflow-y: auto;
        }

        .brand {
            padding: 0 10px 25px;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }

        .brand h2 {
            margin: 0;
            font-size: 25px;
            letter-spacing: -.5px;
        }

        .brand p {
            margin: 6px 0 0;
            color: #ddd6fe;
            font-size: 10px;
            line-height: 1.5;
            letter-spacing: .5px;
        }

        .menu-title {
            margin: 25px 10px 10px;
            color: #c4b5fd;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 5px;
            padding: 12px 13px;
            border-radius: 9px;
            color: #ede9fe;
            font-size: 13px;
            text-decoration: none;
            transition: background .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.15);
            color: #ffffff;
        }

        .menu a.active {
            font-weight: 700;
            box-shadow: inset 3px 0 #c4b5fd;
        }

        .menu-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 25px;
            flex-shrink: 0;
            border-radius: 7px;
            background: rgba(255,255,255,.1);
            font-size: 11px;
        }

        .sidebar-bottom {
            margin-top: 28px;
            padding: 18px 10px 0;
            border-top: 1px solid rgba(255,255,255,.15);
        }

        .user-name {
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .user-role {
            margin-bottom: 15px;
            color: #c4b5fd;
            font-size: 11px;
        }

        .logout-button {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 8px;
            background: transparent;
            color: white;
            font-family: inherit;
            font-size: 12px;
            text-align: left;
            cursor: pointer;
        }

        .logout-button:hover {
            background: rgba(255,255,255,.1);
        }

        .main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 22px 32px;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-label {
            color: var(--muted);
            font-size: 12px;
        }

        .topbar strong {
            color: #4c1d95;
            font-size: 14px;
        }

        .content {
            max-width: 1500px;
            margin: 0 auto;
            padding: 32px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: #1f2937;
            font-size: 27px;
            letter-spacing: -.5px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 15px;
            border: 0;
            border-radius: 8px;
            background: var(--purple);
            color: #ffffff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s;
        }

        .btn:hover { background: var(--purple-dark); }

        .btn-secondary {
            background: #ede9fe;
            color: #5b21b6;
        }

        .btn-secondary:hover { background: #ddd6fe; }

        .btn-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-danger:hover { background: #fecaca; }

        .panel {
            padding: 24px;
            border: 1px solid #ede9fe;
            border-radius: 14px;
            background: white;
            box-shadow: 0 4px 18px rgba(76,29,149,.04);
        }

        .panel-heading {
            margin-bottom: 20px;
        }

        .panel-heading h2 {
            margin: 0 0 6px;
            font-size: 16px;
        }

        .panel-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .search-box {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
            padding: 17px;
            border: 1px solid #ede9fe;
            border-radius: 10px;
            background: #faf9ff;
        }

        .search-field {
            flex: 1;
            min-width: 200px;
        }

        .search-field label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-size: 12px;
            font-weight: 700;
        }

        .search-field input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            background: white;
            font-family: inherit;
            font-size: 13px;
        }

        .search-field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(109,40,217,.1);
        }

        .result-info {
            margin-bottom: 15px;
            color: var(--muted);
            font-size: 12px;
        }

        .message {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #bbf7d0;
            border-radius: 9px;
            background: #f0fdf4;
            color: #166534;
            font-size: 13px;
        }

        .message.error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .table-wrap {
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 13px;
            border-bottom: 1px solid #f0edf7;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f8f5ff;
            color: #5b467d;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        td {
            color: #374151;
            font-size: 12px;
            line-height: 1.6;
        }

        tbody tr:hover { background: #fcfbff; }

        .category-name {
            color: #312e81;
            font-weight: 700;
        }

        .description {
            min-width: 150px;
            max-width: 300px;
            overflow-wrap: anywhere;
        }

        .date-text {
            white-space: nowrap;
            color: #6b7280;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .actions form { margin: 0; }

        .actions .btn {
            padding: 8px 11px;
            font-size: 11px;
        }

        .empty {
            padding: 35px 15px;
            color: var(--muted);
            text-align: center;
        }

        .pagination {
            margin-top: 22px;
            overflow-x: auto;
        }

        .pagination nav p {
            font-size: 12px;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            :root { --sidebar-width: 210px; }

            .content { padding: 24px 20px; }
            .topbar { padding: 20px; }
            .panel { padding: 18px; }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: static;
                width: 100%;
                padding: 18px;
            }

            .brand { padding-bottom: 16px; }
            .menu-title { margin-top: 18px; }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 4px;
            }

            .menu a { margin: 0; padding: 9px; }
            .menu-number { width: 22px; height: 22px; }

            .sidebar-bottom { margin-top: 18px; }

            .main { margin-left: 0; }
            .topbar { padding: 16px 20px; }
            .content { padding: 22px 14px; }
            h1 { font-size: 23px; }
            .panel { padding: 14px; }
            .page-heading .btn { width: 100%; }
            .search-box { align-items: stretch; }
            .search-field { min-width: 100%; }
            .search-box .btn { flex: 1; }
        }
    </style>
</head>

<body>
    @php
        $role = auth()->user()->role ?? 'admin';
        $dashboardRoute = match ($role) {
            'staff' => 'staff.dashboard',
            'customer' => 'customer.dashboard',
            default => 'dashboard',
        };
    @endphp

    <aside class="sidebar">
        <div class="brand">
            <h2>Stockify</h2>
            <p>INVENTORY &amp; SALES SYSTEM</p>
        </div>

        <nav class="menu">
            <div class="menu-title" style="grid-column: 1 / -1;">Menu Utama</div>

            <a href="{{ route($dashboardRoute) }}">
                <span class="menu-number">01</span>
                Dashboard
            </a>

            <a href="{{ route('categories.index') }}" class="active">
                <span class="menu-number">02</span>
                Kategori Produk
            </a>

            <a href="{{ route('products.index') }}">
                <span class="menu-number">03</span>
                Data Produk
            </a>

            <div class="menu-title" style="grid-column: 1 / -1;">Transaksi</div>

            <a href="{{ route('purchases.index') }}">
                <span class="menu-number">04</span>
                Pembelian
            </a>

            <a href="{{ route('sales.index') }}">
                <span class="menu-number">05</span>
                Penjualan
            </a>

            <a href="{{ route('stock-movements.index') }}">
                <span class="menu-number">06</span>
                Riwayat Stok
            </a>

            <div class="menu-title" style="grid-column: 1 / -1;">Lainnya</div>

            <a href="{{ route('suppliers.index') }}">
                <span class="menu-number">07</span>
                Data Pemasok
            </a>

            @if ($role === 'admin')
                <a href="{{ route('users.index') }}">
                    <span class="menu-number">08</span>
                    Kelola Pengguna
                </a>
            @endif
        </nav>

        <div class="sidebar-bottom">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ ucfirst($role) }} Stockify</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Keluar dari akun</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div>
                <strong>Manajemen Inventaris</strong>
                <div class="topbar-label">Kelola kategori produk Stockify</div>
            </div>
            <div class="topbar-label">{{ now()->format('d/m/Y') }}</div>
        </header>

        <main class="content">
            <div class="page-heading">
                <div>
                    <h1>Kategori Produk</h1>
                    <div class="subtitle">
                        Kelola dan kelompokkan produk berdasarkan kategori inventaris.
                    </div>
                </div>

                <a class="btn" href="{{ route('categories.create') }}">
                    + Tambah Kategori
                </a>
            </div>

            @if (session('success'))
                <div class="message">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif

            <section class="panel">
                <div class="panel-heading">
                    <h2>Daftar Kategori</h2>
                    <p>Lihat, cari, dan kelola kategori produk yang tersimpan.</p>
                </div>

                <form method="GET"
                      action="{{ route('categories.index') }}"
                      class="search-box">

                    <div class="search-field">
                        <label for="search">Cari Kategori</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Ketik nama kategori..."
                        >
                    </div>

                    <button type="submit" class="btn">Cari</button>

                    <a class="btn btn-secondary"
                       href="{{ route('categories.index') }}">
                        Reset
                    </a>
                </form>

                <div class="result-info">
                    @if (!empty($search))
                        Hasil pencarian untuk "<strong>{{ $search }}</strong>":
                        {{ $categories->total() }} kategori ditemukan.
                    @else
                        Menampilkan {{ $categories->total() }} kategori.
                    @endif
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                                    <td class="category-name">{{ $category->name }}</td>
                                    <td class="description">
                                        {{ $category->description ?: '—' }}
                                    </td>
                                    <td class="date-text">
                                        {{ $category->created_at->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-secondary"
                                               href="{{ route('categories.edit', $category) }}">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('categories.destroy', $category) }}"
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
                                    <td colspan="5" class="empty">
                                        @if (!empty($search))
                                            Kategori tidak ditemukan. Coba kata kunci lain.
                                        @else
                                            Belum ada kategori. Klik "Tambah Kategori" untuk memulai.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            </section>
        </main>
    </div>
</body>
</html>