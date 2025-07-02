<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-top-left-radius: .5rem;
            border-bottom-left-radius: .5rem;
        }
        @media (max-width: 767px) {
            .register-img {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-sm" style="max-width: 800px; min-width: 350px;">
            <div class="row g-0">
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/logo_with_bg.png') }}" alt="Login" class="register-img">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center">Login</h3>
                        <form method="POST" action="{{ route('postlogin') }}">
                            @csrf
                            @if(\Session::has('message'))
                                <span class="error text-danger">
                                    {{ \Session::get('message') }}
                                </span>
                            @endif
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required autofocus>
                                <span class="error text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <span class="error text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}">Don't have an account? Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
