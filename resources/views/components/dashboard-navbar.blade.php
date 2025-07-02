<header style="position: fixed; top: 0; left: 0; width: 100%; min-height: 60px; z-index: 100; background: var(--bar-color); display: flex; align-items: center;">
    <!-- Back button on the left -->
    <div style="flex: 1; display: flex;">
        <a href="{{ $route }}" class="back-btn" style="margin-left: 20px; display: flex; align-items: center;">
            <i class="fa-solid fa-left-long"></i> Back
        </a>
    </div>
    <!-- Centered logo -->
    <div style="flex: 1; display: flex; justify-content: center;">
        <a href="{{ route('home') }}" class="navbar-logo" style="display: block;">
            <img src="{{ asset('images/banner_logo.png') }}" alt="Logo" style="height:300px; width:auto; display:block;">
        </a>
    </div>
    <!-- Profile on the right -->
    <div style="flex: 1; display: flex; justify-content: flex-end;">
        <div class="profile open-profile-panel" style="margin-right: 20px; display: flex; align-items: center; cursor: pointer;">
            <img src="{{ asset(Auth::user()->image_path) }}" alt="profile" class="profile_img">
            <i class="fa-solid fa-angles-down"></i>
            <span class="notifications_count">{{ $unreadNotifications }}</span>
        </div>
    </div>
</header>
