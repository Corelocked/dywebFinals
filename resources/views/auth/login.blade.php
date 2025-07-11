<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .auth-container {
            max-width: 900px;
            min-width: 350px;
            width: 90%;
        }
        
        .auth-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .register-img {
            object-fit: cover;
            height: 500px;
            width: 100%;
            object-position: center;
        }
        
        .form-container {
            padding: 3rem 2.5rem;
            background: white;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 2rem;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 2px solid #e1e5e9;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 500;
            transition: transform 0.2s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #5a67d8 0%, #6b4993 100%);
        }
        
        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-link:hover {
            color: #5a67d8;
            text-decoration: underline;
        }
        
        @media (max-width: 767px) {
            .form-container {
                padding: 2rem 1.5rem;
                min-height: auto;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="auth-container">
            <div class="card auth-card border-0">
                <div class="row g-0">
                    <div class="col-md-6 d-none d-md-block">
                        <img src="{{ asset('images/logo_with_bg.png') }}" alt="Login" class="register-img">
                    </div>
                    <div class="col-md-6">
                        <div class="form-container">
                            <h3 class="form-title text-center">Welcome Back</h3>
                            <form method="POST" action="{{ route('postlogin') }}">
                                @csrf
                                @if(\Session::has('message'))
                                    <div class="alert alert-danger">
                                        {{ \Session::get('message') }}
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus>
                                    @if($errors->has('email'))
                                        <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                    @if($errors->has('password'))
                                        <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
                            </form>
                            <div class="text-center">
                                <a href="{{ route('register') }}" class="auth-link">Don't have an account? Create one</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
