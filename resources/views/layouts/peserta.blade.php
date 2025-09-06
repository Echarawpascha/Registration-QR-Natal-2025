<!DOCTYPE html>
<html>
<head>
    <title>Peserta - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Christmas Registration</h1>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('peserta.dashboard') }}" 
                   class="{{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('peserta.barcode') }}" 
                   class="{{ request()->routeIs('peserta.barcode') ? 'active' : '' }}">
                    <i class="fas fa-qrcode"></i> Barcode Saya
                </a>
            </li>
        </ul>
        <div class="profile-section">
            <button class="profile-button">
                <img src="{{ Auth::guard('peserta')->user()->profile_image
                    ? asset('storage/' . Auth::guard('peserta')->user()->profile_image)
                    : asset('storage/profile_images/profile.png') }}"
                    alt="Profile" class="profile-image">
                <div class="profile-info">
                    <p class="name">{{ Auth::guard('peserta')->user()->name }}</p>
                    <p class="role">Peserta</p>
                </div>
                <i class="fas fa-chevron-down arrow"></i>
            </button>
            <div class="popup-menu">
                <a href="{{ route('peserta.settings') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="{{ route('peserta.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('peserta.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
