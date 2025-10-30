<!DOCTYPE html>
<html>
<head>
    <title>Peserta - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <script src="{{ asset('js/sidebar-updated.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('peserta.dashboard') }}" class="navbar-brand">
            <i class="fas fa-tree-christmas"></i> Christmas Registration
        </a>

        <ul class="navbar-menu" id="navbar-menu">
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

        <div class="navbar-profile">
            <button class="profile-button" onclick="toggleProfileMenu()">
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
            <div class="popup-menu" id="profile-menu">
                <a href="{{ route('peserta.settings') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="{{ route('peserta.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <div class="overlay" id="overlay" onclick="closeMobileMenu()"></div>

    <form id="logout-form" action="{{ route('peserta.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
