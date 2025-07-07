<x-main-layout>
    <div class="article">
        <div class="contact_form">
            <div class="leave_message">Leave a message!</div>
            
            @if(session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="body_form">
                <img src="{{ asset('images/open.png') }}" alt="Contact Us" loading="lazy">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <label for="name">Full Name <span style="color: var(--error-500);">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                    
                    <label for="email">Email Address <span style="color: var(--error-500);">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                    
                    <label for="message">Your Message <span style="color: var(--error-500);">*</span></label>
                    <textarea id="message" name="message" placeholder="Tell us what's on your mind..." required>{{ old('message') }}</textarea>
                    
                    <input type="submit" value="Send Message">
                </form>
            </div>
        </div>
    </div>
</x-main-layout>