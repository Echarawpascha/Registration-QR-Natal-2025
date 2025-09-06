<!DOCTYPE html>
<html>
<head>
    <title>Register Peserta</title>
</head>
<body>
    <h1>Register Peserta</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.register') }}">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation" required><br>

        <label>Telepon:</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}"><br>

        <label>Keterangan:</label><br>
        <textarea name="address">{{ old('address') }}</textarea><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('peserta.login') }}">Login di sini</a></p>
</body>
</html>