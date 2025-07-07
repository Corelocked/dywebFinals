<x-main-layout>
    <div class="article">
        <div class="contact_form">
            <div class="leave_message">Leave a message!</div>
            <div class="body_form">
                <img src="{{ asset('images/open.png') }}" alt="Contact Us" loading="lazy">
                <form method="POST" action="#">
                    @csrf
                    <label for="name">Full Name <span style="color: var(--error-500);">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    
                    <label for="email">Email Address <span style="color: var(--error-500);">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    
                    <label for="message">Your Message <span style="color: var(--error-500);">*</span></label>
                    <textarea id="message" name="body" placeholder="Tell us what's on your mind..." required></textarea>
                    
                    <input type="submit" value="Send Message">
                </form>
            </div>
        </div>
    </div>
</x-main-layout>