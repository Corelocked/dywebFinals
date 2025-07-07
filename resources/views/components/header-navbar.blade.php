<header class="main-header">
    <div class="header-content">
        <!-- Brand/Logo -->
        <a href="{{ route('home') }}" class="logo">
            <i class="fas fa-feather-alt"></i>
            BlogShark
        </a>
        
        <!-- Navigation -->
        <nav class="main-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Home
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                Contact
            </a>
        </nav>
        
        <!-- User Section -->
        <div class="header-actions">
            @if(Auth::user())
                <!-- Notifications -->
                <button class="notification-btn open-user-panel" title="Notifications">
                    <i class="fa-regular fa-bell"></i>
                    @if($unreadNotifications > 0)
                        <span class="notification-badge">{{ $unreadNotifications }}</span>
                    @endif
                </button>
                
                <!-- Profile -->
                <button class="profile open-profile-panel" title="Profile Menu">
                    <img src="{{ asset(Auth::user()->image_path) }}" alt="Profile" class="profile-avatar">
                    <span class="profile-name">{{ Auth::user()->firstname }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
            @else
                <a href="{{ route('login') }}" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            @endif
        </div>
    </div>
</header>
