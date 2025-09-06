<!DOCTYPE html>
<html>
<head>
    <title>Panitia - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Christmas Registration</h3>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('panitia.dashboard') }}" 
                   class="{{ Request::routeIs('panitia.dashboard') ? 'active' : '' }}">
                   <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('panitia.scan') }}" 
                   class="{{ Request::routeIs('panitia.scan') ? 'active' : '' }}">
                   <i class="fas fa-qrcode"></i> Scan
                </a>
            </li>
            <li>
                <a href="{{ route('panitia.attendance-list') }}" 
                   class="{{ Request::routeIs('panitia.attendance-list') ? 'active' : '' }}">
                   <i class="fas fa-list"></i> Daftar Absensi Hari Ini
                </a>
            </li>
        </ul>
        <div class="profile-section">
            <button class="profile-button">
                <img src="{{ Auth::guard('panitia')->user()->profile_image ? asset('storage/' . Auth::guard('panitia')->user()->profile_image) : asset('storage/profile_images/profile.png') }}" alt="Profile" class="profile-image">
                <div class="profile-info">
                    <p class="name">{{ Auth::guard('panitia')->user()->name }}</p>
                    <p class="role">Panitia</p>
                </div>
                <i class="fas fa-chevron-down arrow"></i>
            </button>
            <div class="popup-menu">
                <a href="{{ route('panitia.settings') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="{{ route('panitia.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('panitia.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
