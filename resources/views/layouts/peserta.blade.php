<!DOCTYPE html>
<html>
<head>
    <title>Peserta - @yield('title')</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('peserta.barcode') }}">Barcode Saya</a></li>
            <li><a href="{{ route('peserta.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </nav>

    <form id="logout-form" action="{{ route('peserta.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
