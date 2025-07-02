<header style="position: fixed; top: 0; left: 0; width: 100%; z-index: 100; display: flex; align-items: center; justify-content: space-between; height: 60px; background: var(--bar-color); padding: 0 32px;">
    <a href="{{ route('home') }}" style="margin-right: 24px; font-size: 18px;">
        Home
    </a>
    <a href="{{ route('contact') }}" style="margin-right: 24px; font-size: 18px;">
        Contact
    </a>
    @if(Auth::user())
        <div style="display: flex; align-items: center;">
            <!-- Notification icon -->
            <a href="#" class="navbar-notifications open-user-panel" style="position: relative; margin-right: 20px;">
                <i class="fa-regular fa-bell" style="font-size: 22px;"></i>
                @if($unreadNotifications > 0)
                    <span class="notification-dot"></span>
                @endif
            </a>
            <a href="#" class="profile open-profile-panel" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ Auth::User() ? asset(Auth::user()->image_path) : '' }}" alt="profile" class="profile_img" style="height:32px; width:32px; border-radius:50%;">
                <i class="fa-solid fa-angles-down"></i>
            </a>
        </div>
    @else
        <a href="{{ route('login') }}" style="font-size: 18px;">
            Login
        </a>
    @endif
</header>
