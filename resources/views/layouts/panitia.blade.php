<!DOCTYPE html>
<html>
<head>
    <title>Panitia - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('panitia.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('panitia.scan') }}">Scan</a></li>
            <li><a href="{{ route('panitia.attendance-list') }}">Daftar Absensi Hari Ini</a></li>
            <li><a href="{{ route('peserta.barcode') }}">Barcode Saya</a></li>
            <li><a href="{{ route('panitia.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </nav>

    <form id="logout-form" action="{{ route('panitia.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
