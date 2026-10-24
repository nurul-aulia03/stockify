<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun | Stockify</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", sans-serif;
            background: #f7f5ff;
            color: #29243b;
        }
        .container { max-width: 1100px; margin: auto; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        h1 { margin: 0 0 8px; font-size: 28px; }
        p { color: #77718b; margin: 0; }
        .button {
            display: inline-block;
            padding: 11px 17px;
            background: #7048e8;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 9px;
            font-weight: 600;
            cursor: pointer;
        }
        .secondary { background: #e9e3ff; color: #5835bd; }
        .card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 20px #30205a0b;
            overflow-x: auto;
        }
        .success {
            background: #e2f8e9;
            color: #18743b;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .search-form input {
            flex: 1;
            min-width: 220px;
            padding: 12px 14px;
            border: 1px solid #ded7f2;
            border-radius: 9px;
            font: inherit;
            outline-color: #7048e8;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            text-align: left;
            padding: 15px 12px;
            border-bottom: 1px solid #eeeaf6;
        }
        th { color: #77718b; font-size: 13px; }
        .role {
            display: inline-block;
            background: #eee8ff;
            color: #623bd0;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }
        .empty { text-align: center; color: #77718b; padding: 30px; }
        .pagination { margin-top: 20px; }
        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 12px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Manajemen Akun</h1>
            <p>Kelola akun Admin, Staff, dan Customer Stockify.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="button secondary">Dashboard</a>
            <a href="{{ route('users.create') }}" class="button">+ Tambah Akun</a>
        </div>
    </div>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <form method="GET" action="{{ route('users.index') }}" class="search-form">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama, email, atau peran..."
            >
            <button type="submit" class="button">Cari</button>
            @if ($search !== '')
                <a href="{{ route('users.index') }}" class="button secondary">Reset</a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="role">{{ $user->role ?? 'admin' }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            @if ($search !== '')
                                Akun yang cocok dengan pencarian tidak ditemukan.
                            @else
                                Belum ada akun.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</div>
</body>
</html>