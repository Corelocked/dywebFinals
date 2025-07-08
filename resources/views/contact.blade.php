<x-main-layout>
    <div class="contact-page">
        <!-- Hero Section -->
        <div class="contact-hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="fas fa-comments"></i>
                        Get in Touch
                    </h1>
                    <p class="hero-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">24h</div>
                        <div class="stat-label">Response Time</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="contact-content">
            <div class="content-wrapper">
                <!-- Contact Form Section -->
                <div class="contact-form-section full-width">
                    <div class="form-card">
                        <div class="form-header">
                            <h2>
                                <i class="fas fa-paper-plane"></i>
                                Send us a Message
                            </h2>
                            <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <div class="alert-content">
                                    <i class="fas fa-check-circle"></i>
                                    <div class="alert-text">
                                        <strong>Message Sent!</strong>
                                        <p>{{ session('success') }}</p>
                                    </div>
                                    <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-error">
                                <div class="alert-content">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div class="alert-text">
                                        <strong>Please fix the following errors:</strong>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                            @csrf
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-user"></i>
                                        Full Name <span class="required">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i>
                                        Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">
                                        <i class="fas fa-phone"></i>
                                        Phone Number
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number (optional)">
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject">
                                        <i class="fas fa-tag"></i>
                                        Subject <span class="required">*</span>
                                    </label>
                                    <select id="subject" name="subject" required>
                                        <option value="">Select a subject</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="business" {{ old('subject') == 'business' ? 'selected' : '' }}>Business Partnership</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="message">
                                        <i class="fas fa-comment-alt"></i>
                                        Your Message <span class="required">*</span>
                                    </label>
                                    <textarea id="message" name="message" placeholder="Tell us what's on your mind..." required rows="6">{{ old('message') }}</textarea>
                                    <div class="character-count">
                                        <span id="charCount">0</span> / 1000 characters
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-footer">
                                <div class="privacy-notice">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Your information is secure and will never be shared with third parties.</span>
                                </div>
                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Send Message</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <div class="faq-container">
                <div class="faq-header">
                    <h2>
                        <i class="fas fa-question-circle"></i>
                        Frequently Asked Questions
                    </h2>
                    <p>Quick answers to common questions</p>
                </div>
                
                <div class="faq-grid">
                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-clock"></i>
                            <h3>How quickly will you respond?</h3>
                        </div>
                        <p>We typically respond to all inquiries within 24 hours during business days.</p>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-envelope"></i>
                            <h3>What's the best way to contact you?</h3>
                        </div>
                        <p>The contact form on this page is the best way to reach us. We read every message carefully.</p>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-globe"></i>
                            <h3>Do you work with international clients?</h3>
                        </div>
                        <p>Absolutely! We work with clients worldwide and accommodate different time zones.</p>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-cogs"></i>
                            <h3>What services do you offer?</h3>
                        </div>
                        <p>We offer web development, design, consulting, and ongoing support services.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Contact Page Styles */
        .contact-page {
            min-height: 100vh;
            width: 100%;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, var(--surface-primary) 0%, var(--surface-secondary) 100%);
            /* Override any inherited constraints */
            max-width: none !important;
            box-sizing: border-box;
        }

        /* Reset any container constraints for contact page */
        body:has(.contact-page) {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Ensure no inherited width constraints */
        .contact-page * {
            box-sizing: border-box;
        }

        /* Hero Section */
        .contact-hero {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
            width: 100%;
            margin: 0;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            background-size: 50px 50px;
            opacity: 0.3;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            flex: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .hero-title i {
            font-size: 3rem;
            opacity: 0.9;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin: 0;
            line-height: 1.6;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* Main Content */
        .contact-content {
            padding: 4rem 0;
            width: 100%;
        }

        .content-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .contact-form-section.full-width {
            width: 100%;
        }

        /* Contact Form */
        .form-card {
            background: var(--surface-primary);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h2 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0 0 1rem 0;
            font-size: 1.75rem;
            color: var(--text-primary);
        }

        .form-header h2 i {
            color: var(--primary-500);
        }

        .form-header p {
            color: var(--text-secondary);
            margin: 0;
        }

        /* Alerts */
        .alert {
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid;
        }

        .alert-success {
            background: var(--success-50);
            border-color: var(--success-200);
        }

        .alert-error {
            background: var(--error-50);
            border-color: var(--error-200);
        }

        .alert-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
        }

        .alert-content i {
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }

        .alert-success .alert-content i {
            color: var(--success-600);
        }

        .alert-error .alert-content i {
            color: var(--error-600);
        }

        .alert-text {
            flex: 1;
        }

        .alert-text strong {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .alert-text p {
            margin: 0;
            color: var(--text-secondary);
        }

        .alert-text ul {
            margin: 0;
            padding-left: 1.25rem;
            color: var(--text-secondary);
        }

        .alert-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .alert-close:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        /* Form Styles */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
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
            font-size: 0.875rem;
        }

        .form-group label i {
            color: var(--primary-500);
            width: 16px;
        }

        .required {
            color: var(--error-500);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 1rem 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: var(--surface-elevated);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-500);
            background: var(--surface-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .character-count {
            text-align: right;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .privacy-notice {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .privacy-notice i {
            color: var(--success-500);
        }

        .submit-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, var(--primary-700), var(--primary-800));
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
        }

        /* FAQ Section */
        .faq-section {
            background: var(--surface-secondary);
            padding: 4rem 0;
            border-top: 1px solid var(--border-color);
            width: 100%;
        }

        .faq-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .faq-header h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin: 0 0 1rem 0;
            font-size: 2rem;
            color: var(--text-primary);
        }

        .faq-header h2 i {
            color: var(--primary-500);
        }

        .faq-header p {
            color: var(--text-secondary);
            margin: 0;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .faq-item {
            background: var(--surface-primary);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .faq-question {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .faq-question i {
            color: var(--primary-500);
            font-size: 1.125rem;
        }

        .faq-question h3 {
            margin: 0;
            font-size: 1.125rem;
            color: var(--text-primary);
        }

        .faq-item p {
            margin: 0;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Dark Mode */
        [data-theme="dark"] .contact-hero {
            background: linear-gradient(135deg, var(--primary-700) 0%, var(--primary-900) 100%);
        }

        [data-theme="dark"] .info-card,
        [data-theme="dark"] .form-card,
        [data-theme="dark"] .faq-item {
            background: var(--surface-elevated);
        }

        [data-theme="dark"] .stat-item {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
                padding: 0 1.5rem;
            }

            .hero-stats {
                justify-content: center;
            }

            .content-wrapper {
                padding: 0 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .contact-content,
            .faq-section {
                padding: 2rem 0;
            }

            .content-wrapper,
            .faq-container {
                padding: 0 1rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .form-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .faq-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .contact-hero {
                padding: 2rem 0;
            }

            .hero-content {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 2rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .content-wrapper,
            .faq-container {
                padding: 0 1rem;
            }

            .info-card,
            .form-card {
                padding: 1rem;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
    </style>

    <script>
        // Character counter for message textarea
        document.addEventListener('DOMContentLoaded', function() {
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            
            if (messageTextarea && charCount) {
                function updateCharCount() {
                    const count = messageTextarea.value.length;
                    charCount.textContent = count;
                    
                    if (count > 1000) {
                        charCount.style.color = 'var(--error-500)';
                    } else if (count > 800) {
                        charCount.style.color = 'var(--warning-500)';
                    } else {
                        charCount.style.color = 'var(--text-secondary)';
                    }
                }
                
                messageTextarea.addEventListener('input', updateCharCount);
                updateCharCount(); // Initial count
            }

            // Form validation enhancements
            const form = document.querySelector('.contact-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('.submit-btn');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Sending...</span>';
                    submitBtn.disabled = true;
                });
            }

            // Auto-hide alerts after 8 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 500);
                }, 8000);
            });
        });
    </script>
</x-main-layout>