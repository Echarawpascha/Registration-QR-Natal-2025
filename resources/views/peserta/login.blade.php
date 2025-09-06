<!DOCTYPE html>
<html>
<head>
    <title>Login Peserta</title>
</head>
<body>
    <h1>Login Peserta</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.login') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('peserta.register') }}">Daftar di sini</a></p>
</body>
</html>