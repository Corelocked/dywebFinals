<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                    <img src="{{ asset('images/logo_with_bg.png') }}" alt="Register" class="register-img">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center">Register</h3>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                            <span id="password-match-message" style="color:red;"></span>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}">Already have an account? Login</a>
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

