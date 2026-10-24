<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff | Stockify</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --primary: #6d4aff;
            --primary-dark: #5035c9;
            --primary-soft: #f1edff;
            --background: #f8f9fc;
            --white: #ffffff;
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

        a { text-decoration: none; color: inherit; }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
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
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-number {
            width: 24px;
            font-size: 10px;
            font-weight: 800;
            color: #aaa7bb;
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
            font-size: 16px;
            font-weight: 800;
        }

        .account-info strong { display: block; font-size: 12px; }

        .account-info small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 36px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg, #38267d, #7053e8);
            box-shadow: 0 12px 32px rgba(83, 58, 175, 0.12);
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            top: -115px;
            right: -50px;
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgba(255,255,255,0.04),
                        0 0 0 58px rgba(255,255,255,0.035);
        }

        .hero-label {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 6px;
            color: #e8e0ff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .hero h1 {
            position: relative;
            z-index: 1;
            margin: 19px 0 10px;
            font-size: clamp(24px, 3vw, 34px);
            letter-spacing: -1px;
        }

        .hero p {
            position: relative;
            z-index: 1;
            max-width: 470px;
            margin: 0;
            color: #e4ddff;
            font-size: 13px;
            line-height: 1.9;
        }

        .hero-footer {
            position: relative;
            z-index: 1;
            margin-top: 25px;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,0.18);
            color: #eee9ff;
            font-size: 11px;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 15px;
            margin: 34px 0 18px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 19px;
            letter-spacing: -0.5px;
        }

        .section-heading p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .section-count {
            padding: 7px 10px;
            border-radius: 7px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .menu-card {
            display: flex;
            flex-direction: column;
            min-height: 190px;
            padding: 23px;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: var(--white);
            transition: 0.2s ease;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            border-color: #d7ccff;
            box-shadow: 0 12px 28px rgba(54, 42, 100, 0.07);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .card-number {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
        }

        .card-arrow {
            color: #aaa5bd;
            font-size: 19px;
            transition: 0.2s;
        }

        .menu-card:hover .card-arrow {
            color: var(--primary);
            transform: translateX(3px);
        }

        .menu-card h3 {
            margin: 0 0 9px;
            font-size: 14px;
            font-weight: 750;
        }

        .menu-card p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .card-link {
            margin-top: auto;
            padding-top: 17px;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
        }

        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-top: 35px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
            color: #9997a8;
            font-size: 11px;
        }

        .logout {
            padding: 10px 15px;
            border: 1px solid #e8e5f0;
            border-radius: 9px;
            background: white;
            color: #625a77;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout:hover {
            border-color: #d7ccff;
            background: var(--primary-soft);
            color: var(--primary);
        }

        @media (max-width: 1100px) {
            .sidebar { width: 220px; }
            .main { padding: 25px; }
        }

        @media (max-width: 700px) {
            .layout { display: block; }
            .sidebar { width: 100%; padding: 18px; }
            .brand { padding-bottom: 18px; }
            .menu-label { margin-top: 20px; }
            .sidebar-bottom { margin-top: 20px; }
            .main { padding: 22px 16px; }
            .topbar { margin-bottom: 22px; }
            .hero { padding: 27px 23px; }
            .menu-grid { grid-template-columns: 1fr; }
            .menu-card { min-height: 165px; }
            .footer { align-items: flex-start; flex-direction: column; }
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

        <a href="{{ route('staff.dashboard') }}" class="nav-link active">
            <span class="nav-number">01</span> Dashboard
        </a>

        <a href="{{ route('products.index') }}" class="nav-link">
            <span class="nav-number">02</span> Data Produk
        </a>

        <div class="menu-label">TRANSAKSI</div>

        <a href="{{ route('purchases.index') }}" class="nav-link">
            <span class="nav-number">03</span> Pembelian
        </a>

        <a href="{{ route('sales.index') }}" class="nav-link">
            <span class="nav-number">04</span> Penjualan
        </a>

        <a href="{{ route('stock-movements.index') }}" class="nav-link">
            <span class="nav-number">05</span> Riwayat Stok
        </a>

        <div class="sidebar-bottom">
            <strong>Stockify Inventory</strong>
            <p>Sistem pengelolaan persediaan dan transaksi barang dalam satu tempat.</p>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="breadcrumb">
                Halaman Utama / <strong>Dashboard Staff</strong>
            </div>

            <div class="account">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="account-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Staff</small>
                </div>
            </div>
        </header>

        <section class="hero">
            <div class="hero-label">RUANG KERJA STAFF</div>
            <h1>Selamat datang, {{ auth()->user()->name }}.</h1>
            <p>
                Kelola persediaan dan aktivitas operasional Stockify
                dengan lebih teratur. Pilih menu yang tersedia untuk
                mulai mengelola data dan transaksi.
            </p>
            <div class="hero-footer">INVENTORY MANAGEMENT · STOCKIFY</div>
        </section>

        <section class="section-heading">
            <div>
                <h2>Akses Menu</h2>
                <p>Pilih fitur yang ingin kamu buka.</p>
            </div>
            <span class="section-count">4 FITUR</span>
        </section>

        <section class="menu-grid">
            <a href="{{ route('products.index') }}" class="menu-card">
                <div class="card-top">
                    <div class="card-number">01</div>
                    <span class="card-arrow">↗</span>
                </div>
                <h3>Data Produk</h3>
                <p>Lihat informasi produk, SKU, harga, dan jumlah persediaan.</p>
                <span class="card-link">Buka data produk</span>
            </a>

            <a href="{{ route('purchases.index') }}" class="menu-card">
                <div class="card-top">
                    <div class="card-number">02</div>
                    <span class="card-arrow">↗</span>
                </div>
                <h3>Pembelian</h3>
                <p>Catat pembelian barang dan pantau persediaan masuk.</p>
                <span class="card-link">Buka pembelian</span>
            </a>

            <a href="{{ route('sales.index') }}" class="menu-card">
                <div class="card-top">
                    <div class="card-number">03</div>
                    <span class="card-arrow">↗</span>
                </div>
                <h3>Penjualan</h3>
                <p>Kelola transaksi penjualan dan pengurangan stok.</p>
                <span class="card-link">Buka penjualan</span>
            </a>

            <a href="{{ route('stock-movements.index') }}" class="menu-card">
                <div class="card-top">
                    <div class="card-number">04</div>
                    <span class="card-arrow">↗</span>
                </div>
                <h3>Riwayat Stok</h3>
                <p>Periksa catatan perubahan stok dari setiap transaksi.</p>
                <span class="card-link">Lihat riwayat stok</span>
            </a>
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