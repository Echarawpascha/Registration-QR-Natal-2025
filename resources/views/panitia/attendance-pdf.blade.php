<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Absensi Hari Ini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status-present {
            color: #22c55e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Daftar Absensi Hari Ini - {{ now()->format('d M Y') }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Waktu Scan</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Asal Gereja</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attendance['peserta_name'] }}</td>
                <td>{{ $attendance['scanned_at'] }}</td>
                <td>{{ $attendance['phone'] ?: '-' }}</td>
                <td>{{ $attendance['email'] }}</td>
                <td>{{ $attendance['church_origin'] ?: '-' }}</td>
                <td>
                    @if($attendance['status'] === 'present')
                        <span class="status-present">Hadir</span>
                    @else
                        {{ $attendance['status'] }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data absensi hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
