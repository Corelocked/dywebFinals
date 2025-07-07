/**
 * Comments Enhancement Script
 * Provides improved interactivity and user experience for the comments section
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize comment enhancements
    initializeCommentEnhancements();
});

/**
 * Initialize all comment-related enhancements
 */
function initializeCommentEnhancements() {
    enhanceCommentForm();
    enhanceCommentActions();
    addCommentInteractions();
    addAccessibilityFeatures();
}

/**
 * Enhance the comment form with better UX
 */
function enhanceCommentForm() {
    const commentForm = document.querySelector('.add__comment form');
    const submitButton = document.querySelector('.add__comment input[type="submit"]');
    const textarea = document.querySelector('.add__comment textarea');
    
    if (!commentForm || !submitButton || !textarea) return;
    
    // Add character counter
    addCharacterCounter(textarea);
    
    // Enhanced form submission
    commentForm.addEventListener('submit', function(e) {
        const body = textarea.value.trim();
        
        // Basic validation
        if (body.length < 3) {
            e.preventDefault();
            showFormMessage('Please write at least 3 characters for your comment.', 'error');
            textarea.focus();
            return false;
        }
        
        if (body.length > 2000) {
            e.preventDefault();
            showFormMessage('Your comment is too long. Please keep it under 2000 characters.', 'error');
            textarea.focus();
            return false;
        }
        
        // Show loading state
        setSubmitButtonLoading(submitButton, true);
    });
    
    // Auto-resize textarea
    textarea.addEventListener('input', function() {
        autoResizeTextarea(this);
        updateCharacterCounter(this);
    });
    
    // Initial setup
    autoResizeTextarea(textarea);
}

/**
 * Add character counter to textarea
 */
function addCharacterCounter(textarea) {
    const maxLength = 2000;
    const counter = document.createElement('div');
    counter.className = 'character-counter';
    counter.innerHTML = `<span class="current">0</span>/<span class="max">${maxLength}</span>`;
    
    // Insert counter after textarea
    textarea.parentNode.insertBefore(counter, textarea.nextSibling);
    
    // Add CSS for counter
    if (!document.getElementById('comment-counter-styles')) {
        const style = document.createElement('style');
        style.id = 'comment-counter-styles';
        style.textContent = `
            .character-counter {
                text-align: right;
                font-size: 0.875rem;
                color: var(--text-secondary);
                margin-top: -1rem;
                margin-bottom: 1rem;
                transition: color 0.2s ease;
            }
            .character-counter.warning {
                color: var(--warning-600);
            }
            .character-counter.error {
                color: var(--error-600);
            }
        `;
        document.head.appendChild(style);
    }
}

/**
 * Update character counter
 */
function updateCharacterCounter(textarea) {
    const counter = textarea.parentNode.querySelector('.character-counter');
    if (!counter) return;
    
    const current = textarea.value.length;
    const max = 2000;
    const currentSpan = counter.querySelector('.current');
    
    if (currentSpan) {
        currentSpan.textContent = current;
    }
    
    // Update counter style based on length
    counter.classList.remove('warning', 'error');
    if (current > max * 0.9) {
        counter.classList.add('error');
    } else if (current > max * 0.8) {
        counter.classList.add('warning');
    }
}

/**
 * Auto-resize textarea based on content
 */
function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = Math.max(140, textarea.scrollHeight) + 'px';
}

/**
 * Show form message (success/error)
 */
function showFormMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessage = document.querySelector('.form-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `form-message form-message--${type}`;
    messageDiv.textContent = message;
    
    const form = document.querySelector('.add__comment form');
    form.insertBefore(messageDiv, form.firstChild);
    
    // Add CSS for messages if not exists
    if (!document.getElementById('form-message-styles')) {
        const style = document.createElement('style');
        style.id = 'form-message-styles';
        style.textContent = `
            .form-message {
                padding: 1rem;
                border-radius: 0.75rem;
                margin-bottom: 1rem;
                font-weight: 600;
                border: 2px solid;
                animation: slideIn 0.3s ease-out;
            }
            .form-message--info {
                background: var(--primary-50);
                color: var(--primary-700);
                border-color: var(--primary-200);
            }
            .form-message--error {
                background: var(--error-50);
                color: var(--error-700);
                border-color: var(--error-200);
            }
            .form-message--success {
                background: var(--success-50);
                color: var(--success-700);
                border-color: var(--success-200);
            }
            @keyframes slideIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            messageDiv.style.opacity = '0';
            messageDiv.style.transform = 'translateY(-10px)';
            setTimeout(() => messageDiv.remove(), 300);
        }
    }, 5000);
}

/**
 * Set loading state for submit button
 */
function setSubmitButtonLoading(button, loading) {
    if (loading) {
        button.disabled = true;
        button.dataset.originalText = button.value;
        button.value = '⏳ Posting...';
        button.style.opacity = '0.7';
        button.style.cursor = 'not-allowed';
    } else {
        button.disabled = false;
        button.value = button.dataset.originalText || 'Post Comment';
        button.style.opacity = '1';
        button.style.cursor = 'pointer';
    }
}

/**
 * Enhance comment action buttons
 */
function enhanceCommentActions() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const confirmation = confirm(
                'Are you sure you want to delete this comment?\\n\\n' +
                'This action cannot be undone.'
            );
            
            if (confirmation) {
                const form = this.closest('form');
                if (form) {
                    // Add loading state
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Deleting...</span>';
                    this.disabled = true;
                    form.submit();
                }
            }
        });
    });
}

/**
 * Add interactive features to comments
 */
function addCommentInteractions() {
    const comments = document.querySelectorAll('.comment');
    
    comments.forEach((comment, index) => {
        // Add staggered animation delay
        comment.style.animationDelay = `${index * 0.1}s`;
        
        // Add hover effects for avatar tooltips
        const avatar = comment.querySelector('.avatar-circle');
        const author = comment.querySelector('.comment-author');
        
        if (avatar && author) {
            avatar.title = `Comment by ${author.textContent}`;
        }
        
        // Add click-to-expand for long comments
        const body = comment.querySelector('.comment-body');
        if (body && body.textContent.length > 300) {
            addExpandableComment(body);
        }
    });
}

/**
 * Add expandable functionality for long comments
 */
function addExpandableComment(body) {
    const fullText = body.innerHTML;
    const shortText = fullText.substring(0, 300) + '...';
    
    body.innerHTML = shortText;
    
    const expandButton = document.createElement('button');
    expandButton.className = 'expand-comment-btn';
    expandButton.textContent = 'Read more';
    expandButton.type = 'button';
    
    body.appendChild(expandButton);
    
    // Add CSS for expand button
    if (!document.getElementById('expand-comment-styles')) {
        const style = document.createElement('style');
        style.id = 'expand-comment-styles';
        style.textContent = `
            .expand-comment-btn {
                background: none;
                border: none;
                color: var(--primary-600);
                font-weight: 600;
                cursor: pointer;
                margin-left: 0.5rem;
                padding: 0.25rem 0.5rem;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                font-size: 0.875rem;
            }
            .expand-comment-btn:hover {
                background: var(--primary-50);
                transform: translateY(-1px);
            }
        `;
        document.head.appendChild(style);
    }
    
    expandButton.addEventListener('click', function() {
        if (body.classList.contains('expanded')) {
            body.innerHTML = shortText;
            body.appendChild(expandButton);
            expandButton.textContent = 'Read more';
            body.classList.remove('expanded');
        } else {
            body.innerHTML = fullText;
            const collapseBtn = document.createElement('button');
            collapseBtn.className = 'expand-comment-btn';
            collapseBtn.textContent = 'Show less';
            collapseBtn.type = 'button';
            body.appendChild(collapseBtn);
            body.classList.add('expanded');
            
            collapseBtn.addEventListener('click', function() {
                body.innerHTML = shortText;
                body.appendChild(expandButton);
                expandButton.textContent = 'Read more';
                body.classList.remove('expanded');
            });
        }
    });
}

/**
 * Add accessibility features
 */
function addAccessibilityFeatures() {
    // Add keyboard navigation for action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    
    actionButtons.forEach(button => {
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Add focus management for form
    const textarea = document.querySelector('.add__comment textarea');
    if (textarea) {
        // Focus textarea when comment section comes into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.5) {
                    // Optional: Auto-focus could be intrusive, so we'll skip it
                    // textarea.focus();
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(textarea.closest('.add__comment'));
    }
}

/**
 * Smooth scroll to comment after posting (if redirected back)
 */
function scrollToNewComment() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('comment_added')) {
        setTimeout(() => {
            const commentsSection = document.querySelector('.comments');
            if (commentsSection) {
                commentsSection.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        }, 500);
    }
}

// Initialize smooth scroll on page load
document.addEventListener('DOMContentLoaded', scrollToNewComment);
