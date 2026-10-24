<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify | Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
              font-family: "Segoe UI", Arial, sans-serif;
            background: #f6f4fc;
            color: #29243b;
            min-height: 100vh;
        }
 
        .sidebar {
            width: 245px;
            background: #fff;
            border-right: 1px solid #e9e4f5;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 30px 18px;
        }

        .brand {
            padding: 0 12px 30px;
            border-bottom: 1px solid #eee9f7;
        }

        .brand h1 {
            color: #7046c5;
            font-size: 27px;
        }

        .brand p {
            color: #9991aa;
            font-size: 10px;
            margin-top: 6px;
            letter-spacing: 1.2px;
        }

        .menu-label {
            color: #a29aaf;
            font-size: 11px;
            font-weight: 700;
            margin: 28px 12px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 7px;
            color: #6d657c;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #f0e9ff;
            color: #7046c5;
            font-weight: 600;
        }

        .nav-number {
            font-size: 11px;
            font-weight: 700;
            color: #9475d1;
            min-width: 20px;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 25px;
            left: 18px;
            right: 18px;
        }

        .logout {
            width: 100%;
            border: 1px solid #eee3f7;
            background: #fff;
            color: #a04d72;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout:hover {
            background: #fff0f5;
        }

        .main {
            margin-left: 245px;
            padding: 32px 38px;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
              align-items: center;
            margin-bottom: 30px;
        }

        .role-badge {
            background: #eee7ff;
            color: #7046c5;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
         }

        .welcome {
            background: linear-gradient(120deg, #7046c5, #9473dc);
            color: #fff;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 24px rgba(112, 70, 197, 0.12);
        }

        .welcome h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .welcome p {
            font-size: 14px;
            line-height: 1.7;
            color: #f0eaff;
            max-width: 650px;
        }

        .section-heading {
            display: flex;
             justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .section-heading h3 {
            font-size: 18px;
        }

        .section-heading span {
            color: #938aa2;
            font-size: 12px;
          }
  
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .menu-card {
            background: #fff;
            border: 1px solid #eee9f7;
            border-radius: 15px;
            padding: 23px;
            text-decoration: none;
            color: inherit;
            min-height: 165px;
            transition: 0.2s;
        }

        .menu-card:hover {
            border-color: #b9a1ed;
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(70, 45, 120, 0.07);
        }

        .card-number {
            display: inline-block;
            color: #7046c5;
            background: #f0e9ff;
            border-radius: 8px;
            padding: 8px 11px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .menu-card h4 {
            font-size: 15px;
            margin-bottom: 8px;
        }

        .menu-card p {
            font-size: 12px;
            line-height: 1.6;
            color: #92899f;
        }

          .footer {
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid #e9e4f5;
            color: #a29aaf;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 1050px) {
            .menu-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                padding: 20px;
                border-right: none;
                border-bottom: 1px solid #e9e4f5;
            }

            .sidebar-bottom {
                position: static;
                margin-top: 20px;
            }

            .main {
                margin-left: 0;
                padding: 24px 18px;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .welcome {
                padding: 24px;
            }
        }
    </style>
</head>

  <body>
    <aside class="sidebar">
        <div class="brand">
            <h1>Stockify</h1>
            <p>INVENTORY &amp; SALES SYSTEM</p>
        </div>

        <div class="menu-label">Menu Utama</div>

        <a href="{{ route('staff.dashboard') }}" class="nav-link active">
            <span class="nav-number">01</span>
            Dashboard
        </a>

        <a href="{{ route('products.index') }}" class="nav-link">
            <span class="nav-number">02</span>
            Data Produk
        </a>

        <div class="menu-label">Transaksi</div>

        <a href="{{ route('purchases.index') }}" class="nav-link">
            <span class="nav-number">03</span>
            Pembelian
        </a>

        <a href="{{ route('sales.index') }}" class="nav-link">
            <span class="nav-number">04</span>
            Penjualan
        </a>

        <a href="{{ route('stock-movements.index') }}" class="nav-link">
            <span class="nav-number">05</span>
            Pergerakan Stok
        </a>

        <a href="{{ route('orders.index') }}" class="nav-link">
            <span class="nav-number">06</span>
            Pesanan Customer
        </a>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout">Keluar dari Akun</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <span class="role-badge">STAFF</span>
        </div>

        <section class="welcome">
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>
                Pantau dan kelola kegiatan operasional melalui menu yang tersedia.
                Pilih menu untuk membuka data produk, transaksi, pergerakan stok,
                dan pesanan customer.
            </p>
        </section>

        <div class="section-heading">
            <h3>Menu Operasional</h3>
            <span>6 menu tersedia</span>
        </div>

        <section class="menu-grid">
            <a href="{{ route('staff.dashboard') }}" class="menu-card">
                <span class="card-number">01</span>
                <h4>Dashboard</h4>
                <p>Halaman utama untuk mengakses menu operasional.</p>
            </a>

            <a href="{{ route('products.index') }}" class="menu-card">
                <span class="card-number">02</span>
                <h4>Data Produk</h4>
                <p>Lihat dan kelola informasi produk inventaris.</p>
            </a>

            <a href="{{ route('purchases.index') }}" class="menu-card">
                <span class="card-number">03</span>
                <h4>Pembelian</h4>
                <p>Catat barang masuk dari pemasok.</p>
            </a>

            <a href="{{ route('sales.index') }}" class="menu-card">
                <span class="card-number">04</span>
                <h4>Penjualan</h4>
                <p>Kelola transaksi penjualan produk.</p>
            </a>

            <a href="{{ route('stock-movements.index') }}" class="menu-card">
                <span class="card-number">05</span>
                <h4>Pergerakan Stok</h4>
                <p>Periksa riwayat perubahan jumlah stok.</p>
            </a>

            <a href="{{ route('orders.index') }}" class="menu-card">
                <span class="card-number">06</span>
                <h4>Pesanan Customer</h4>
                <p>Lihat daftar pesanan yang masuk dari customer.</p>
            </a>
        </section>

        <footer class="footer">
            Stockify &copy; {{ date('Y') }} — Inventory &amp; Sales Management System
        </footer>
      </main>
</body>
</html>