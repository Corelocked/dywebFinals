{{-- Dashboard-specific user panel with both notification and profile panels --}}
<div class="modal">
    {{-- Profile Panel --}}
    <div class="modal-profile hidden" style="margin-top: 72px;">
        <span>Welcome!</span>
        <i class="fa-solid fa-circle-xmark close close-modal"></i>
        <div class="notifications switch-to-notifications" style="cursor: pointer;" title="View notifications">{{ $unreadNotifications }} <i class="fa-solid fa-angles-right"></i></div>
        <p class="name">{{ Auth::User() ? Auth::User()->firstname . ' ' . Auth::User()->lastname : '' }}</p>
        <p class="role_profile">{{ Auth::User() ? Auth::User()->roles[0]->name : '' }}</p>
        <p class="info">Available actions</p>
        <a href="{{ route('dashboard') }}" class="button"><i class="fa-solid fa-wrench"></i><p>Panel</p></a>
        <a href="{{ route('profile') }}" class="button"><i class="fa-solid fa-id-card"></i><p>Profile</p></a>
        <div class="button toggle-mode" onClick="toggleMode();"><i class="fa-solid fa-moon"></i><p>Dark Mode</p></div>
        <a href="{{ route('logout') }}" class="button"><i class="fa-solid fa-right-from-bracket"></i><p>Logout</p></a>
        <p class="info">Quick actions</p>
        @can('post-create')
            <a href="{{ route('posts.create') }}" class="button"><i class="fa-solid fa-plus"></i><p>Add post</p></a>
        @endcan
        @can('category-create')
            <a href="{{ route('categories.create') }}" class="button"><i class="fa-solid fa-square-plus"></i><p>Add category</p></a>
        @endcan
        @can('user-create')
            <a href="{{ route('users.create') }}" class="button"><i class="fa-solid fa-user-plus"></i><p>Add user</p></a>
        @endcan
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="button"><i class="fa-solid fa-wrench"></i><p>Add role</p></a>
        @endcan
        <div class="line-1"></div>
        <div class="clock">
            <p class="info">Current time</p>
            <div class="time">
                <span id="hours">23</span>
                <span id="minutes">59</span>
            </div>
        </div>
        <div class="line-1"></div>
    </div>

    {{-- Notifications Panel --}}
    <div class="modal-notifications hidden" style="margin-top: 72px;">
        <div class="back"><i class="fa-solid fa-angles-left"></i> <p>Back</p></div>
        @if (count($notifications) === 0)
            <div class="notification action">
                <p class="empty">No notifications</p>
            </div>
        @else
            <div class="notification action">
                <div class="clear_notifications" onclick="clearNotifications();">Clear notifications</div>
            </div>
        @endif
        @php
            $groupedNotifications = $notifications->groupBy(function ($notification) {
                return $notification->created_at->format('Y-m-d');
            });
        @endphp
        @foreach($groupedNotifications as $date => $notificationsGroup)
            <p class="date">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</p>
            @foreach($notificationsGroup as $notification)
                <div class="notification {{ $notification->read_at ? 'read' : 'unread' }}">
                    @if($notification->type === 'App\Notifications\CommentNotification')
                        <div class="notification-content">
                            <p>{{ $notification->data['message'] ?? 'New comment notification' }}</p>
                            <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @elseif($notification->type === 'App\Notifications\PostNotification')
                        <div class="notification-content">
                            <p>{{ $notification->data['message'] ?? 'New post notification' }}</p>
                            <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @elseif($notification->type === 'App\Notifications\RoleNotification')
                        <div class="notification-content">
                            <p>Your role has been updated to <strong>{{ $notification->data['new_role'] }}</strong></p>
                            <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @else
                        <div class="notification-content">
                            <p>{{ $notification->data['message'] ?? 'New notification' }}</p>
                            <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>
</div>
