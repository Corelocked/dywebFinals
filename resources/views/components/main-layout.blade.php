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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <h3>BlogSpace</h3>
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
                    <p>&copy; 2025 BlogSpace. Created by Patrick Miguel Babala, Christian Denzon & Cedric Joshua Palapuz</p>
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
