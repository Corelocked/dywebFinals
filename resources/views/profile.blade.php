<x-main-layout>
    <div class="article">
        <div class="profile_form profile-enhanced">
            <div class="profile-header">
                <div class="profile-title">
                    <i class="fa-solid fa-user-edit"></i>
                    <h1>Edit Profile</h1>
                </div>
                <p class="profile-subtitle">Update your personal information and preferences</p>
            </div>
            
            @if(session('success'))
                <div class="success-container">
                    <div class="success-header">
                        <i class="fa-solid fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="success-close-btn">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            <div class="profile-content">
                <form action="{{ route('users.update', Auth::User()->id) }}" method="POST" enctype="multipart/form-data" class="profile-form-enhanced">
                    @csrf
                    @method('PATCH')
                    
                    @if(count($errors) > 0)
                        <div class="error-container">
                            <div class="error-header">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                <span>Please fix the following errors:</span>
                            </div>
                            <ul class="error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Profile Image Section -->
                    <div class="profile-image-section">
                        <div class="profile-avatar-container">
                            <div class="profile-avatar-wrapper">
                                <img src="{{ Auth::user()->image_path }}" id="output" alt="Profile Picture" class="profile-avatar-img">
                                <div class="profile-avatar-overlay">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Change Photo</span>
                                </div>
                            </div>
                            <button type="button" class="profile-image-btn" onClick="document.getElementById('profile_update_form_profile_image').click()">
                                <i class="fa-solid fa-image"></i>
                                <span>Upload Photo</span>
                            </button>
                        </div>
                        <input type="file" name="image" id="profile_update_form_profile_image" accept="image/*" onchange="loadFile(event)" style="display: none;">
                    </div>

                    <!-- Form Fields -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstname">
                                <i class="fa-solid fa-user"></i>
                                First Name
                            </label>
                            <input type="text" id="firstname" name="firstname" value="{{ Auth::User()->firstname }}" placeholder="Enter your first name">
                        </div>

                        <div class="form-group">
                            <label for="lastname">
                                <i class="fa-solid fa-user"></i>
                                Last Name
                            </label>
                            <input type="text" id="lastname" name="lastname" value="{{ Auth::User()->lastname }}" placeholder="Enter your last name">
                        </div>

                        <div class="form-group full-width">
                            <label for="email">
                                <i class="fa-solid fa-envelope"></i>
                                Email Address
                            </label>
                            <div class="input-with-note">
                                <input type="email" id="email" value="{{ Auth::User()->email }}" disabled>
                                <p class="input-note">
                                    <i class="fa-solid fa-info-circle"></i>
                                    To change your email, contact the Administrator
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="fa-solid fa-lock"></i>
                                New Password
                            </label>
                            <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="fa-solid fa-lock"></i>
                                Confirm Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                        </div>
                    </div>

                    <input type="hidden" name="profile_update" value="True">
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="window.history.back()">
                            <i class="fa-solid fa-arrow-left"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-save"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Profile Page Styles */
        .profile-enhanced {
            max-width: 900px;
            margin: 2rem auto;
            background: var(--surface-primary);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
            color: white;
            padding: 3rem 3rem 2rem 3rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .profile-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .profile-title i {
            font-size: 2rem;
            opacity: 0.9;
        }

        .profile-title h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(45deg, #fff 0%, rgba(255, 255, 255, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .profile-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin: 0;
            font-weight: 400;
        }

        .profile-content {
            padding: 3rem;
        }

        .profile-form-enhanced {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        /* Error Handling */
        .error-container {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #f87171;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .error-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .error-header i {
            font-size: 1.25rem;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            color: #b91c1c;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(185, 28, 28, 0.1);
        }

        .error-list li:last-child {
            border-bottom: none;
        }

        /* Profile Image Section */
        .profile-image-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            padding: 2rem;
            background: var(--surface-secondary);
            border-radius: 20px;
            border: 1px solid var(--border-color);
        }

        .profile-avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .profile-avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            opacity: 0;
            transition: all 0.3s ease;
            color: white;
        }

        .profile-avatar-wrapper:hover .profile-avatar-overlay {
            opacity: 1;
        }

        .profile-avatar-overlay i {
            font-size: 2rem;
        }

        .profile-avatar-overlay span {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .profile-image-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .profile-image-btn:hover {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .form-group label i {
            font-size: 1.125rem;
            color: var(--primary-500);
            width: 20px;
        }

        .form-group input {
            padding: 1rem 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: var(--surface-elevated);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: var(--surface-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .form-group input:disabled {
            background: var(--surface-muted);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .input-with-note {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .input-note {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
            padding: 0.75rem;
            background: var(--surface-muted);
            border-radius: 8px;
            border-left: 3px solid var(--primary-400);
        }

        .input-note i {
            color: var(--primary-500);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-primary, .btn-secondary {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-700), var(--primary-800));
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: var(--surface-secondary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--surface-elevated);
            border-color: var(--primary-300);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Dark Theme */
        html[data-theme='dark'] .profile-enhanced {
            background: #1e293b;
            border-color: #334155;
        }

        html[data-theme='dark'] .profile-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        html[data-theme='dark'] .profile-image-section {
            background: #334155;
            border-color: #475569;
        }

        html[data-theme='dark'] .error-container {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
            border-color: #dc2626;
        }

        html[data-theme='dark'] .form-group input {
            background: #334155;
            border-color: #475569;
            color: #f8fafc;
        }

        html[data-theme='dark'] .form-group input:focus {
            background: #1e293b;
            border-color: #3b82f6;
        }

        html[data-theme='dark'] .form-group input:disabled {
            background: #475569;
            color: #94a3b8;
        }

        html[data-theme='dark'] .input-note {
            background: #475569;
            color: #cbd5e1;
        }

        html[data-theme='dark'] .btn-secondary {
            background: #334155;
            color: #f8fafc;
            border-color: #475569;
        }

        html[data-theme='dark'] .btn-secondary:hover {
            background: #475569;
            border-color: #60a5fa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-enhanced {
                margin: 1rem;
                border-radius: 16px;
            }

            .profile-header {
                padding: 2rem 1.5rem;
            }

            .profile-title h1 {
                font-size: 2rem;
            }

            .profile-content {
                padding: 2rem 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .profile-avatar-wrapper {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            .profile-header {
                padding: 1.5rem 1rem;
            }

            .profile-title {
                flex-direction: column;
                gap: 0.5rem;
            }

            .profile-title h1 {
                font-size: 1.75rem;
            }

            .profile-content {
                padding: 1.5rem 1rem;
            }

            .profile-avatar-wrapper {
                width: 100px;
                height: 100px;
            }
        }
    </style>

    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        // Auto-hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successContainer = document.querySelector('.success-container');
            if (successContainer) {
                // Function to hide the success message
                function hideSuccessMessage() {
                    successContainer.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    successContainer.style.opacity = '0';
                    successContainer.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        successContainer.style.display = 'none';
                    }, 500);
                }

                // Auto-hide after 8 seconds
                setTimeout(hideSuccessMessage, 8000);

                // Also add click handler for close button
                const closeBtn = successContainer.querySelector('.success-close-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', hideSuccessMessage);
                }
            }
        });
    </script>
</x-main-layout>