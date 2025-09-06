<!DOCTYPE html>
<html>
<head>
    <title>Menunggu Approval</title>
</head>
<body>
    <h1>Pendaftaran Panitia Berhasil</h1>

    @if (session('success'))
        <div style="color:green;">
            {{ session('success') }}
        </div>
    @endif

    <p>Akun Anda sedang menunggu persetujuan dari admin. Silakan hubungi admin untuk proses approval.</p>

    <p><a href="{{ route('panitia.login') }}">Kembali ke Login</a></p>
</body>
</html>
