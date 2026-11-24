<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventaris Barang') | Inventaris Barang</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f3f4f6; color: #1f2937; display: flex; flex-direction: column; min-height: 100vh; }
        header { background: #1d4ed8; color: #fff; padding: 18px 24px; }
        header h1 { margin: 0; font-size: 22px; }
        header p { margin: 4px 0 0; font-size: 13px; opacity: .85; }
        nav { background: #1e3a8a; padding: 0 24px; }
        nav a { display: inline-block; color: #fff; text-decoration: none; padding: 12px 14px; font-size: 14px; }
        nav a:hover, nav a.aktif { background: #2563eb; }
        main { flex: 1; width: 100%; max-width: 1000px; margin: 24px auto; padding: 0 16px; }
        .kartu { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .kartu h2 { margin-top: 0; }
        footer { background: #111827; color: #d1d5db; text-align: center; padding: 14px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px 10px; text-align: left; }
        th { background: #eff6ff; }
        .btn { display: inline-block; padding: 6px 12px; border: 0; border-radius: 5px; font-size: 13px; color: #fff; text-decoration: none; cursor: pointer; }
        .btn-biru { background: #2563eb; } .btn-kuning { background: #d97706; }
        .btn-merah { background: #dc2626; } .btn-abu { background: #6b7280; } .btn-hijau { background: #16a34a; }
        .aksi { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
        .aksi form { margin: 0; }
        .alert { padding: 12px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .alert-sukses { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .alert-gagal { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .kosong { text-align: center; color: #6b7280; padding: 28px 0; }
        .baris-atas { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
        .cari { display: flex; gap: 6px; }
        .cari input { padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 5px; }
        label { display: block; font-weight: bold; margin: 12px 0 4px; font-size: 14px; }
        input[type=text], input[type=number], select, textarea { width: 100%; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px; font-family: inherit; }
        input[readonly] { background: #f3f4f6; }
        .error { color: #dc2626; font-size: 13px; margin-top: 3px; }
        .detail td:first-child { width: 180px; font-weight: bold; background: #f9fafb; }
        .badge { padding: 2px 8px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .badge-baik { background: #dcfce7; color: #166534; }
        .badge-ringan { background: #fef3c7; color: #92400e; }
        .badge-berat { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <header>
        <h1>Sistem Inventaris Barang</h1>
        <p>UTS Pemrograman Berorientasi Objek &middot; Laravel</p>
    </header>

    <nav>
        <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.index') ? 'aktif' : '' }}">Daftar Barang</a>
        <a href="{{ route('barang.create') }}" class="{{ request()->routeIs('barang.create') ? 'aktif' : '' }}">Tambah Barang</a>
    </nav>

    <main>
        @if (session('success'))
            <div class="alert alert-sukses">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-gagal">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Inventaris Barang &middot; UTS PBO Ganjil T.A. 2026/2027
    </footer>
</body>
</html>