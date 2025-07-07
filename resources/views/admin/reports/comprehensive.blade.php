<!DOCTYPE html>
<html>
<head>
    <title>{{ $reportTitle }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Pastikan font ini tersedia atau ganti */
            font-size: 10pt;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #047857;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #047857;
            font-size: 24pt;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
            color: #555;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            background-color: #059669;
            color: white;
            padding: 10px 15px;
            margin-bottom: 15px;
            font-size: 14pt;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        .stats-grid {
            display: table; /* Menggunakan display table untuk layout yang mirip grid di PDF */
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-item {
            display: table-cell;
            width: 33.33%; /* Sesuaikan lebar kolom */
            text-align: center;
            padding: 15px;
            background-color: #e6ffe6; /* Light green */
            border: 1px solid #cce6cc;
            border-radius: 8px;
            vertical-align: top; /* Agar konten sejajar di atas */
        }
        .stats-item h3 {
            margin: 0 0 5px;
            color: #047857;
            font-size: 11pt;
        }
        .stats-item p {
            margin: 0;
            font-size: 20pt;
            font-weight: bold;
            color: #059669;
        }
        .footer-pdf {
            text-align: center;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            font-size: 8pt;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $reportTitle }}</h1>
            <p>Dibuat pada: {{ $generatedAt }}</p>
        </div>

        <div class="section">
            <h2>Ringkasan Statistik</h2>
            <div class="stats-grid">
                <div class="stats-item">
                    <h3>Total Booking</h3>
                    <p>{{ $totalBookings }}</p>
                </div>
                <div class="stats-item">
                    <h3>Total Lapangan</h3>
                    <p>{{ $totalFields }}</p>
                </div>
                <div class="stats-item">
                    <h3>Total Pengguna</h3>
                    <p>{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Booking Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Booking</th>
                        <th>Pengguna</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestBookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->field->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                            <td>{{ $booking->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Tidak ada data booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Daftar Lapangan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lapangan</th>
                        <th>Tipe</th>
                        <th>Harga per Jam</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fields as $field)
                        <tr>
                            <td>{{ $field->id }}</td>
                            <td>{{ $field->name }}</td>
                            <td>{{ $field->type }}</td>
                            <td>Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($field->description, 50) }}</td> {{-- Memotong deskripsi agar tidak terlalu panjang --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data lapangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Daftar Pengguna</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Terdaftar Sejak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer-pdf">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Sport Center') }}. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>