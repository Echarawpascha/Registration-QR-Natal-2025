<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Christmas Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @if(Auth::guard('panitia')->check())
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    @endif

    <style>
        /* === GENERAL STYLING === */
        body {
            margin: 0;
            padding-top: 110px; /* agar konten tidak tertutup navbar */
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
            color: #fff;
        }

        /* === NAVBAR FLOATING GLASS EFFECT === */
        .navbar {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 75%; /* dipendekkan */
            background: rgba(255, 255, 255, 0.12); /* efek kaca lembut */
            backdrop-filter: blur(16px) saturate(140%);
            -webkit-backdrop-filter: blur(16px) saturate(140%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 30px; /* radius lembut */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            z-index: 1000;
            transition: all 0.4s ease;
            animation: fadeDown 0.8s ease;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translate(-50%, -30px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.35);
        }

        /* === BRAND === */
        .navbar-brand {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .navbar-brand i {
            color: #ff4444;
            text-shadow: 0 0 8px rgba(255, 68, 68, 0.6);
        }

        /* === MENU === */
        .navbar-menu {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        .navbar-menu a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-menu a:hover {
            color: #fff;
        }

        .navbar-menu a.active {
            color: #fff;
            font-weight: 600;
            border-bottom: 2px solid #fff;
            padding-bottom: 4px;
        }

        /* === PROFILE === */
        .navbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .profile-button {
            background: transparent;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile-image {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.4);
            box-shadow: 0 0 8px rgba(255,255,255,0.2);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-info .name {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .profile-info .role {
            margin: 0;
            font-size: 0.75rem;
            color: #cfd8dc;
        }

        /* === POPUP MENU === */
        .popup-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            min-width: 180px;
        }

        .popup-menu a {
            display: block;
            padding: 10px 16px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
        }

        .popup-menu a:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        /* === MOBILE === */
        .mobile-menu-toggle {
            display: none;
            color: white;
            background: none;
            border: none;
            font-size: 1.6rem;
        }

        @media (max-width: 768px) {
            .navbar {
                width: 90%;
                padding: 10px 20px;
            }

            .navbar-menu {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
            }
        }

        /* === CONTENT === */
        .main-content {
            padding: 40px 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="{{ Auth::guard('peserta')->check() ? route('peserta.dashboard') : (Auth::guard('panitia')->check() ? route('panitia.dashboard') : route('admin.dashboard')) }}" class="navbar-brand">
            <i class="fas fa-tree"></i> Christmas Registration
        </a>

        <ul class="navbar-menu" id="navbar-menu">
            @if(Auth::guard('peserta')->check())
                <li><a href="{{ route('peserta.dashboard') }}" class="{{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('peserta.barcode') }}" class="{{ request()->routeIs('peserta.barcode') ? 'active' : '' }}"><i class="fas fa-qrcode"></i> Barcode Saya</a></li>
            @elseif(Auth::guard('panitia')->check())
                <li><a href="{{ route('panitia.dashboard') }}" class="{{ Request::routeIs('panitia.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('panitia.scan') }}" class="{{ Request::routeIs('panitia.scan') ? 'active' : '' }}"><i class="fas fa-qrcode"></i> Scan</a></li>
                <li><a href="{{ route('panitia.attendance-list') }}" class="{{ Request::routeIs('panitia.attendance-list') ? 'active' : '' }}"><i class="fas fa-list"></i> Daftar Absensi</a></li>
            @elseif(Auth::guard('admin')->check())
                <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
            @endif
        </ul>

        <div class="navbar-profile">
            @if(Auth::guard('peserta')->check())
                <button class="profile-button" onclick="toggleProfileMenu()">
                    <img src="{{ Auth::guard('peserta')->user()->profile_image ? asset('storage/' . Auth::guard('peserta')->user()->profile_image) : asset('storage/profile_images/profile.png') }}" alt="Profile" class="profile-image">
                    <div class="profile-info">
                        <p class="name">{{ Auth::guard('peserta')->user()->name }}</p>
                        <p class="role">Peserta</p>
                    </div>
                    <i class="fas fa-chevron-down arrow"></i>
                </button>
                <div class="popup-menu" id="profile-menu">
                    <a href="{{ route('peserta.settings') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                    <a href="{{ route('peserta.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            @endif
        </div>

        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()"><i class="fas fa-bars"></i></button>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('navbar-menu');
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }

        // Efek scroll pada navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @if(Auth::guard('peserta')->check())
        <form id="logout-form" action="{{ route('peserta.logout') }}" method="POST" style="display: none;">@csrf</form>
    @endif
</body>
</html>
