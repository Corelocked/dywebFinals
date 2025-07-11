<x-main-layout>
    <div class="dashboard main dashboard-enhanced">
        <!-- Hero Section -->
        <div class="dashboard-hero">
            <div class="hero-content">
                <div class="hero-image-container">
                    <img src="{{ asset('images/moon.jpg') }}" id="dashboard__image" alt="dashboard" class="hero-image">
                    <div class="hero-overlay"></div>
                </div>
                <div class="hero-text">
                    <h1 class="welcome">
                        @auth
                            @if (Auth::user()->roles[0]->name === 'Admin')
                                Welcome to the Admin Panel!
                            @elseif (Auth::user()->roles[0]->name === 'Writer')
                                Welcome to the Writer Panel!
                            @else
                                Welcome to the Panel!
                            @endif
                        @else
                            Welcome, Guest!
                        @endauth
                    </h1>
                    <div class="user-info">
                        <div class="name-and-role">
                            <span class="name_profile">
                                @auth
                                    {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                                @else
                                    Guest
                                @endauth
                            </span>
                            <span class="role_profile">
                                @auth
                                    <span class="role-badge role-{{ strtolower(Auth::user()->roles[0]->name ?? 'user') }}">
                                        {{ Auth::user()->roles[0]->name ?? 'User' }}
                                    </span>
                                @else
                                    <span class="role-badge role-guest">Guest</span>
                                @endauth
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        @auth
        <div class="dashboard-content">
            <!-- Left Side - Quick Action Cards -->
            <div class="dashboard-stats">
                <a href="{{ route('posts.index') }}" class="stat-card stat-link">
                    <div class="stat-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Posts</h3>
                        <p>Browse and manage posts</p>
                    </div>
                </a>
                
                @can('user-list')
                    <a href="{{ route('users.index') }}" class="stat-card stat-link">
                        <div class="stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Users</h3>
                            <p>Manage team members</p>
                        </div>
                    </a>
                @endcan
                
                @can('comment-list')
                    <a href="{{ route('comments.index') }}" class="stat-card stat-link">
                        <div class="stat-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Comments</h3>
                            <p>Browse and moderate</p>
                        </div>
                    </a>
                @endcan
                
                @role('Admin')
                    <a href="{{ route('admin.contacts.index') }}" class="stat-card stat-link">
                        <div class="stat-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Messages</h3>
                            <p>Manage contact messages</p>
                        </div>
                    </a>
                @else
                    <a href="{{ route('contact') }}" class="stat-card stat-link">
                        <div class="stat-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Messages</h3>
                            <p>Contact page</p>
                        </div>
                    </a>
                @endrole
            </div>

            <!-- Right Side - Additional Actions -->
            <div class="actions_home actions-enhanced">
                <h2 class="actions-title">Quick Actions</h2>
                
                <div class="connected">
                    @can('post-create')
                        <a href="{{ route('posts.create') }}" class="button">
                            <i class="fa-solid fa-plus"></i>
                            <p>Add post</p>
                        </a>
                    @endcan
                    @can('category-create')
                        <a href="{{ route('categories.create') }}" class="button">
                            <i class="fa-solid fa-square-plus"></i>
                            <p>Add category</p>
                        </a>
                    @endcan
                </div>
                
                <div class="connected">
                    @can('category-list')
                        <a href="{{ route('categories.index') }}" class="button">
                            <i class="fa-solid fa-layer-group"></i>
                            <p>Browse categories</p>
                        </a>
                    @endcan
                    @can('user-create')
                        <a href="{{ route('users.create') }}" class="button">
                            <i class="fa-solid fa-user-plus"></i>
                            <p>Add user</p>
                        </a>
                    @endcan
                </div>
                
                <div class="connected">
                    @can('role-create')
                        <a href="{{ route('roles.create') }}" class="button">
                            <i class="fa-solid fa-wrench"></i>
                            <p>Add role</p>
                        </a>
                    @endcan
                    @can('role-list')
                        <a href="{{ route('roles.index') }}" class="button">
                            <i class="fa-solid fa-toolbox"></i>
                            <p>Browse roles</p>
                        </a>
                    @endcan
                </div>
                
                @can('image-list')
                    <a href="{{ route('images.index') }}" class="button">
                        <i class="fa-solid fa-image"></i>
                        <p>Browse images</p>
                    </a>
                @endcan
            </div>
        </div>
        @endauth
    </div>
    
    <!-- Include dashboard-specific user panels modal -->
    <x-dashboard-user-panel />

    <style>
        /* Enhanced Dashboard Styles - Override admin.css */
        .dashboard-enhanced {
            padding: 0;
            margin: 80px 0 0 0;
            width: 100%;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
            display: block !important;
            justify-content: unset !important;
            align-items: unset !important;
            flex-direction: unset !important;
            min-height: unset !important;
        }

        /* Override default dashboard styles from admin.css */
        .dashboard.dashboard-enhanced {
            display: block;
            justify-content: unset;
            align-items: unset;
            flex-direction: unset;
            background: transparent;
            color: var(--text-primary);
            border-radius: 0;
            width: 100%;
            margin: 80px 0 0 0;
            min-height: unset;
            box-shadow: none;
            padding: 0;
        }

        .dashboard-hero {
            position: relative;
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
            margin: 0 auto 2.5rem auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
            max-width: 1100px;
            width: calc(100% - 32px);
            min-height: 220px;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2.5rem 3.5rem;
            position: relative;
            gap: 2.5rem;
        }

        .hero-image-container {
            position: relative;
            flex-shrink: 0;
        }

        .hero-image {
            width: 320px;
            height: 200px;
            border-radius: 18px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35);
            margin: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.12) 0%, transparent 100%);
            border-radius: 18px;
            pointer-events: none;
        }

        .hero-text {
            flex: 1;
            margin-left: 2.5rem;
            color: white;
        }

        .dashboard-enhanced .welcome {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            color: white;
            text-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
            background: linear-gradient(45deg, #fff 0%, rgba(255, 255, 255, 0.85) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .name-and-role {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .dashboard-enhanced .name_profile {
            font-size: 1.375rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.96);
            padding: 0;
            margin: 0;
        }

        .dashboard-enhanced .role_profile {
            padding: 0;
            margin: 0;
        }

        .role-badge {
            display: inline-block;
            padding: 0.625rem 1.25rem;
            border-radius: 30px;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.75px;
        }

        .role-admin {
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            color: white;
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.35);
        }

        .role-writer {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            color: white;
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.35);
        }

        .role-user, .role-guest {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
        }

        .dashboard-stats {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .dashboard-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            margin: 0 auto 2rem auto;
            align-items: start;
            max-width: 1100px;
            width: calc(100% - 32px);
            padding: 0 16px;
        }

        .stat-card {
            background: var(--surface-primary);
            border-radius: 18px;
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
        }

        .stat-link:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            text-decoration: none;
            color: inherit;
        }

        .stat-card:not(.stat-link):hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
            color: white;
            font-size: 1.375rem;
        }

        .stat-content h3 {
            margin: 0 0 0.375rem 0;
            font-size: 1.1875rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-content p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 0.8125rem;
        }

        .actions-enhanced {
            background: var(--surface-primary);
            border-radius: 22px;
            padding: 1.875rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
        }

        /* Override admin.css actions_home styles */
        .dashboard-enhanced .actions_home.actions-enhanced {
            display: block !important;
            flex-direction: unset !important;
            margin-bottom: 0 !important;
        }

        .actions-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 1.25rem 0;
            text-align: center;
        }

        .actions-enhanced .connected {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        /* Override admin.css connected styles */
        .dashboard-enhanced .actions_home.actions-enhanced .connected {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .actions-enhanced .connected:last-child {
            display: flex;
            flex-direction: column;
            justify-items: unset;
            margin-bottom: 0;
        }

        .actions-enhanced .button {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.625rem;
            padding: 1.25rem;
            min-height: 68px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            background: var(--surface-secondary);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            text-align: left;
        }

        /* Single button in connected group - better spacing */
        .actions-enhanced .connected:has(.button:only-child) {
            margin-bottom: 1.25rem;
        }

        /* Empty connected groups - hide them */
        .actions-enhanced .connected:empty {
            display: none !important;
        }

        /* Override admin.css button styles */
        .dashboard-enhanced .actions_home.actions-enhanced .button {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 0.625rem !important;
            padding: 1.25rem !important;
            margin: 0 !important;
            min-width: unset !important;
            min-height: 68px !important;
            border-radius: 16px !important;
            border: 1px solid var(--border-color) !important;
            transition: all 0.3s ease !important;
            background: var(--surface-secondary) !important;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05) !important;
            text-decoration: none !important;
            color: var(--text-primary) !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            text-align: left !important;
            user-select: unset !important;
            flex-grow: unset !important;
        }

        .actions-enhanced .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-300);
        }

        .actions-enhanced .button i {
            font-size: 1.125rem;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Override admin.css button icon styles */
        .dashboard-enhanced .actions_home.actions-enhanced .button i {
            padding: 0 !important;
            font-size: 1.125rem !important;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            margin: 0 !important;
        }

        /* Override admin.css button text styles - Very specific override */
        .dashboard-enhanced .actions_home.actions-enhanced .button p {
            margin: 0 !important;
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            text-align: left !important;
            padding: 0 !important;
            font-family: inherit !important;
        }

        .actions-enhanced .button p {
            margin: 0;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-align: left;
        }

        /* Dark theme adjustments */
        html[data-theme='dark'] .dashboard-hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
        }

        html[data-theme='dark'] .hero-image {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.55);
        }

        html[data-theme='dark'] .dashboard-enhanced .welcome {
            background: linear-gradient(45deg, #f8fafc 0%, rgba(248, 250, 252, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        html[data-theme='dark'] .dashboard-enhanced .name_profile {
            color: rgba(248, 250, 252, 0.95);
        }

        html[data-theme='dark'] .stat-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        html[data-theme='dark'] .stat-card:hover {
            background: #334155;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        }

        html[data-theme='dark'] .stat-content h3 {
            color: #f8fafc;
        }

        html[data-theme='dark'] .stat-content p {
            color: #cbd5e1;
        }

        html[data-theme='dark'] .stat-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }

        html[data-theme='dark'] .actions-enhanced {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        html[data-theme='dark'] .actions-title {
            color: #f8fafc;
        }

        html[data-theme='dark'] .actions-enhanced .button {
            background: #334155;
            border-color: #475569;
            color: #f8fafc;
        }

        html[data-theme='dark'] .actions-enhanced .button:hover {
            background: #475569;
            border-color: #64748b;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
        }

        html[data-theme='dark'] .actions-enhanced .button p {
            color: #cbd5e1;
        }

        /* Dark mode - Override admin.css button text styles */
        html[data-theme='dark'] .dashboard-enhanced .actions_home.actions-enhanced .button p {
            color: #cbd5e1 !important;
            text-align: left !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        html[data-theme='dark'] .actions-enhanced .button i {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        html[data-theme='dark'] .role-admin {
            background: linear-gradient(45deg, #dc2626, #ea580c);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.45);
        }

        html[data-theme='dark'] .role-writer {
            background: linear-gradient(45deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.45);
        }

        html[data-theme='dark'] .role-user, 
        html[data-theme='dark'] .role-guest {
            background: linear-gradient(45deg, #4f46e5, #3730a3);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .actions-enhanced .connected {
                flex-direction: column;
            }
            
            .actions-enhanced .connected:last-child {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                padding: 2rem 2.5rem;
                gap: 2rem;
            }

            .hero-text {
                margin-left: 0;
                margin-top: 0;
            }

            .name-and-role {
                margin-left: 0; /* Reset alignment for mobile center layout */
                justify-content: center;
            }

            .dashboard-enhanced .welcome {
                font-size: 2.25rem;
            }

            .dashboard-content {
                margin: 0 auto 2rem auto;
                width: calc(100% - 24px);
                padding: 0 12px;
                max-width: 600px;
            }

            .dashboard-hero {
                margin: 0 auto 2rem auto;
                width: calc(100% - 24px);
                max-width: 600px;
            }
            
            .actions-enhanced .connected {
                flex-direction: column;
                gap: 0.625rem;
                margin-bottom: 0.875rem;
            }
            
            .actions-enhanced .connected:last-child {
                flex-direction: column;
                margin-bottom: 0;
            }
            
            .actions-enhanced .button {
                min-height: 60px;
                padding: 1.125rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 1.75rem 2rem;
            }

            .hero-image {
                width: 240px;
                height: 150px;
            }

            .dashboard-enhanced .welcome {
                font-size: 1.875rem;
            }

            .dashboard-enhanced .name_profile {
                font-size: 1.25rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .actions-enhanced {
                padding: 1.5rem;
            }

            .actions-enhanced .button {
                min-height: 60px;
                padding: 1rem;
            }
        }
    </style>
</x-main-layout>
