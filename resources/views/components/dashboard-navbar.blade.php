<header class="main-header">
    <div class="header-content">
        <!-- Back Navigation (leftmost) -->
        <div class="dashboard-nav">
            <a href="{{ $route }}" class="back-btn">
                <i class="fa-solid fa-left-long"></i>
                <span>Back</span>
            </a>
        </div>
        
        <!-- Brand/Logo (center) -->
        <a href="{{ route('home') }}" class="logo">
            BlogShark
        </a>
        
        <!-- User Actions (rightmost) -->
        <div class="header-actions">
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
        </div>
    </div>
</header>
