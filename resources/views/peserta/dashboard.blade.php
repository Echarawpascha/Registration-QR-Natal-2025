<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peserta</title>
</head>
<body>
    <h1>Selamat datang, {{ $peserta->name }}</h1>

    <p>Email: {{ $peserta->email }}</p>
    <p>Telepon: {{ $peserta->phone }}</p>
    <p>Keterangan : {{ $peserta->address }}</p>

    <h3>Barcode Anda untuk Absensi:</h3>

    {!! DNS2D::getBarcodeSVG($peserta->barcode, 'QRCODE', 4, 4) !!}

    <p>Kode Barcode: {{ $peserta->barcode }}</p>

    <h3>Status Verifikasi:</h3>
    @if($peserta->is_confirmed)
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
            <h4>✅ Barcode Sudah Diverifikasi</h4>
            <p>Barcode Anda sudah discan oleh panitia. Anda dapat masuk ke acara.</p>
        </div>
    @else
        <div style="color: orange; padding: 10px; border: 1px solid orange; margin-bottom: 20px;">
            <h4>⏳ Menunggu Verifikasi</h4>
            <p>Barcode Anda belum discan oleh panitia. Tunjukkan barcode ini kepada panitia di pintu masuk.</p>
        </div>
    @endif

    <p><strong>Catatan:</strong> Pastikan package simplesoftwareio/simple-qrcode sudah terinstall untuk menampilkan barcode QR Code.</p>

    <form method="POST" action="{{ route('peserta.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>