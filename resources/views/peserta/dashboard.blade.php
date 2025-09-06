<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peserta</title>
</head>
<body>
    <h1>Selamat datang, {{ $peserta->name }}</h1>

    <p>Email: {{ $peserta->email }}</p>
    <p>Telepon: {{ $peserta->phone }}</p>
    <p>Alamat: {{ $peserta->address }}</p>

    <h3>Barcode Anda untuk Absensi:</h3>

    {!! DNS2D::getBarcodeSVG($peserta->barcode, 'QRCODE', 4, 4) !!}

    <p>Kode Barcode: {{ $peserta->barcode }}</p>

    <p><strong>Catatan:</strong> Pastikan package simplesoftwareio/simple-qrcode sudah terinstall untuk menampilkan barcode QR Code.</p>

    <form method="POST" action="{{ route('peserta.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>