<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <script src="https://kit.fontawesome.com/15901ecbea.js" crossorigin="anonymous"></script>
    <script>
        const currentTheme = localStorage.getItem("theme") ?? "light";
        if (currentTheme === "dark") {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else if (currentTheme === "light") {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
    @yield('scripts')
    @if(request()->routeIs('dashboard') || request()->routeIs('posts.*') || request()->routeIs('categories.*') || request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('comments.*') || request()->routeIs('admin.contacts.*'))
        @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <!-- SweetAlert Custom Styles - Fix bright colors for better readability -->
    <style>
        /* Base popup styling */
        .swal2-popup {
            background: var(--surface-primary) !important;
            color: var(--text-primary) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .swal2-title {
            color: var(--text-primary) !important;
            font-family: "Inter", sans-serif !important;
            font-weight: 600 !important;
        }

        .swal2-html-container {
            color: var(--text-secondary) !important;
            font-family: "Inter", sans-serif !important;
            line-height: 1.5 !important;
        }

        /* Button styling */
        .swal2-confirm {
            background-color: var(--primary-500) !important;
            color: white !important;
            font-family: "Inter", sans-serif !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3) !important;
        }

        .swal2-confirm:hover {
            background-color: var(--primary-600) !important;
            transform: translateY(-1px) !important;
        }

        .swal2-cancel {
            background-color: var(--neutral-400) !important;
            color: var(--text-primary) !important;
            font-family: "Inter", sans-serif !important;
            border: 1px solid var(--border-color) !important;
        }

        .swal2-cancel:hover {
            background-color: var(--neutral-500) !important;
            color: white !important;
        }

        /* Toast notifications */
        .swal2-toast {
            background: var(--surface-primary) !important;
            color: var(--text-primary) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .swal2-toast .swal2-title {
            color: var(--text-primary) !important;
            font-weight: 600 !important;
        }

        .swal2-toast .swal2-html-container {
            color: var(--text-secondary) !important;
        }

        /* Success alert styling */
        .swal2-popup.swal2-icon-success {
            border-left: 4px solid var(--success-500) !important;
        }
        
        .swal2-popup.swal2-icon-success .swal2-icon {
            border-color: var(--success-500) !important;
            color: var(--success-600) !important;
        }

        .swal2-popup.swal2-icon-success .swal2-success-ring {
            border-color: var(--success-500) !important;
        }

        .swal2-popup.swal2-icon-success .swal2-success-fix {
            background-color: var(--success-500) !important;
        }

        /* Error alert styling */
        .swal2-popup.swal2-icon-error {
            border-left: 4px solid var(--error-500) !important;
        }
        
        .swal2-popup.swal2-icon-error .swal2-icon {
            border-color: var(--error-500) !important;
            color: var(--error-600) !important;
        }

        .swal2-popup.swal2-icon-error .swal2-x-mark {
            background-color: var(--error-500) !important;
        }

        /* Warning alert styling */
        .swal2-popup.swal2-icon-warning {
            border-left: 4px solid var(--warning-500) !important;
        }
        
        .swal2-popup.swal2-icon-warning .swal2-icon {
            border-color: var(--warning-500) !important;
            color: var(--warning-600) !important;
        }

        /* Dark mode specific enhancements */
        [data-theme="dark"] .swal2-popup {
            background: var(--surface-primary) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }

        [data-theme="dark"] .swal2-title {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .swal2-html-container {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .swal2-toast {
            background: var(--surface-primary) !important;
            border-color: var(--border-color) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
        }

        /* Backdrop for better contrast */
        .swal2-backdrop-show {
            background: rgba(0, 0, 0, 0.4) !important;
        }

        [data-theme="dark"] .swal2-backdrop-show {
            background: rgba(0, 0, 0, 0.7) !important;
        }

        /* Contact form specific success/error styling */
        .swal2-popup.contact-alert .swal2-title {
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
        }

        .swal2-popup.contact-alert .swal2-html-container {
            font-size: 1rem !important;
            line-height: 1.6 !important;
        }
    </style>
</head>
<body>
    <x-header-navbar />

    @if(!Auth::User())
        <x-change-theme />
    @endif

    {{ $slot }}

    @if(Auth::User())
        <x-user-panel />
    @endif

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>BlogShark</h3>
                <p>A modern blogging platform where ideas come to life. Share your thoughts, connect with readers, and build your community.</p>
                <div class="footer-social">
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="{{ route('home') }}">Home</a></p>
                <p><a href="{{ route('contact') }}">Contact</a></p>
                @auth
                    <p><a href="{{ route('dashboard') }}">Dashboard</a></p>
                    <p><a href="{{ route('profile') }}">Profile</a></p>
                @else
                    <p><a href="{{ route('login') }}">Login</a></p>
                @endauth
            </div>
            
            <div class="footer-section">
                <h3>Categories</h3>
                <p><a href="#">Technology</a></p>
                <p><a href="#">Lifestyle</a></p>
                <p><a href="#">Business</a></p>
                <p><a href="#">Travel</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Stay Updated</h3>
                <p>Subscribe to our newsletter for the latest posts and updates.</p>
                <div class="footer-newsletter">
                    <form class="footer-newsletter-form" action="#" method="POST">
                        @csrf
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div>
                <div class="footer-credits">
                    <p>&copy; 2025 BlogShark. Created by Patrick Miguel Babala, Christian Denzon & Cedric Joshua Palapuz</p>
                </div>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">About</a>
                    <a href="#">Help</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
