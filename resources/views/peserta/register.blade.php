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

        <label>Asal Gereja:</label><br>
        <select name="church_origin" required>
            <option value="">Pilih Gereja Asal</option>
            <option value="GIA JEMAAT LENGKONG BESAR" {{ old('church_origin') == 'GIA JEMAAT LENGKONG BESAR' ? 'selected' : '' }}>GIA JEMAAT LENGKONG BESAR</option>
            <option value="GIA JEMAAT KOPO PERMAI" {{ old('church_origin') == 'GIA JEMAAT KOPO PERMAI' ? 'selected' : '' }}>GIA JEMAAT KOPO PERMAI</option>
            <option value="GIA JEMAAT TAMAN KOPO INDAH" {{ old('church_origin') == 'GIA JEMAAT TAMAN KOPO INDAH' ? 'selected' : '' }}>GIA JEMAAT TAMAN KOPO INDAH</option>
            <option value="GIA JEMAAT BUDIMAN" {{ old('church_origin') == 'GIA JEMAAT BUDIMAN' ? 'selected' : '' }}>GIA JEMAAT BUDIMAN</option>
            <option value="GIA JEMAAT GALUNGGUNG" {{ old('church_origin') == 'GIA JEMAAT GALUNGGUNG' ? 'selected' : '' }}>GIA JEMAAT GALUNGGUNG</option>
            <option value="GIA JEMAAT MALEER" {{ old('church_origin') == 'GIA JEMAAT MALEER' ? 'selected' : '' }}>GIA JEMAAT MALEER</option>
            <option value="GIA JEMAAT CIUMBULEUIT" {{ old('church_origin') == 'GIA JEMAAT CIUMBULEUIT' ? 'selected' : '' }}>GIA JEMAAT CIUMBULEUIT</option>
            <option value="GIA JEMAAT CIKUTRA" {{ old('church_origin') == 'GIA JEMAAT CIKUTRA' ? 'selected' : '' }}>GIA JEMAAT CIKUTRA</option>
            <option value="GIA JEMAAT PHARMINDO" {{ old('church_origin') == 'GIA JEMAAT PHARMINDO' ? 'selected' : '' }}>GIA JEMAAT PHARMINDO</option>
            <option value="GIA JEMAAT PURWAKARTA" {{ old('church_origin') == 'GIA JEMAAT PURWAKARTA' ? 'selected' : '' }}>GIA JEMAAT PURWAKARTA</option>
            <option value="GIA JEMAAT CIREBON" {{ old('church_origin') == 'GIA JEMAAT CIREBON' ? 'selected' : '' }}>GIA JEMAAT CIREBON</option>
            <option value="GIA JEMAAT JAMBLANG" {{ old('church_origin') == 'GIA JEMAAT JAMBLANG' ? 'selected' : '' }}>GIA JEMAAT JAMBLANG</option>
        </select><br><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('peserta.login') }}">Login di sini</a></p>
</body>
</html>