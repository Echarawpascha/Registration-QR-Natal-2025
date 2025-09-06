<!DOCTYPE html>
<html>
<head>
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Christmas Registration</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
        </ul>
        <div class="profile-section">
            <button class="profile-button">
                <img src="{{ Auth::guard('admin')->user()->profile_image ? asset('storage/' . Auth::guard('admin')->user()->profile_image) : 'https://via.placeholder.com/40x40/cccccc/666666?text=A' }}" alt="Profile" class="profile-image">
                <div class="profile-info">
                    <p class="name">{{ Auth::guard('admin')->user()->name }}</p>
                    <p class="role">Admin</p>
                </div>
                <i class="fas fa-chevron-down arrow"></i>
            </button>
            <div class="popup-menu">
                <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
