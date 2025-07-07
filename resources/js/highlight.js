let slideIndex = 1;
let myTimer;
let isTransitioning = false;

window.currentSlide = function(n) {
    if (isTransitioning) return;
    clearInterval(myTimer);
    showSlides(slideIndex = n);
    startTimer();
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("post-highlighted");
    let dots = document.getElementsByClassName("dot");
    
    if (slides.length === 0) return;
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    
    isTransitioning = true;
    
    // Hide all slides with fade out
    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("fade");
        slides[i].style.zIndex = "1";
    }
    
    // Update dots
    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
        dots[i].className = dots[i].className.replace("fa-solid", "fa-regular");
    }
    
    // Show current slide with fade in after a brief delay
    setTimeout(() => {
        slides[slideIndex-1].style.zIndex = "2";
        slides[slideIndex-1].classList.add("fade");
        dots[slideIndex-1].classList.add("active");
        dots[slideIndex-1].className = dots[slideIndex-1].className.replace("fa-regular", "fa-solid");
        
        setTimeout(() => {
            isTransitioning = false;
        }, 500);
    }, 100);
}

function animateSlides() {
    if (isTransitioning) return;
    let slides = document.getElementsByClassName("post-highlighted");
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    showSlides(slideIndex);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    let slides = document.getElementsByClassName("post-highlighted");
    let dots = document.getElementsByClassName("dot");
    
    // Set initial state
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.zIndex = "1";
        slides[i].classList.remove("fade");
    }
    
    if (slides.length > 0) {
        showSlides(slideIndex);
        startTimer();
    }
});

function startTimer() {
    myTimer = setInterval(animateSlides, 8000);
}

// Add navigation arrows functionality
function nextSlide() {
    if (isTransitioning) return;
    clearInterval(myTimer);
    slideIndex++;
    let slides = document.getElementsByClassName("post-highlighted");
    if (slideIndex > slides.length) {slideIndex = 1}
    showSlides(slideIndex);
    startTimer();
}

function prevSlide() {
    if (isTransitioning) return;
    clearInterval(myTimer);
    slideIndex--;
    let slides = document.getElementsByClassName("post-highlighted");
    if (slideIndex < 1) {slideIndex = slides.length}
    showSlides(slideIndex);
    startTimer();
}

// Expose functions globally
window.nextSlide = nextSlide;
window.prevSlide = prevSlide;
