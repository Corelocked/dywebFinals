<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
            height: 600px;
            width: 100%;
            object-position: center;
        }
        
        .form-container {
            padding: 2.5rem 2.5rem;
            background: white;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
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
        
        .password-match {
            font-size: 0.875rem;
            margin-top: 0.25rem;
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
                        <img src="{{ asset('images/logo_with_bg.png') }}" alt="Register" class="register-img">
                    </div>
                    <div class="col-md-6">
                        <div class="form-container">
                            <h3 class="form-title text-center">Create Account</h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" value="{{ old('firstname') }}" required autofocus>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="{{ old('lastname') }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="name@email.com" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter a secure password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                                    <div id="password-match-message" class="password-match"></div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Create Account</button>
                            </form>
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="auth-link">Already have an account? Sign in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('password_confirmation').addEventListener('input', function() {
            let password = document.getElementById('password').value;
            let confirm = this.value;
            let message = document.getElementById('password-match-message');
            if (confirm.length === 0) {
                message.textContent = '';
            } else if (password === confirm) {
                message.textContent = 'Passwords match!';
                message.style.color = 'green';
            } else {
                message.textContent = 'Passwords do not match!';
                message.style.color = 'red';
            }
        });
    </script>
</body>
</html>

