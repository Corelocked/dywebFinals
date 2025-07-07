// Post list functionality
console.log('Post list JS loaded');

// Ensure confirmDelete function is available globally
window.confirmDelete = function(id, formPrefix) {
    console.log('confirmDelete called:', id, formPrefix);
    
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 not loaded');
        if (confirm('Are you sure you want to delete this item?')) {
            const form = document.getElementById(formPrefix + '_' + id);
            if (form) {
                form.submit();
            } else {
                console.error('Form not found:', formPrefix + '_' + id);
            }
        }
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formPrefix + '_' + id);
            if (form) {
                form.submit();
            } else {
                console.error('Form not found:', formPrefix + '_' + id);
                Swal.fire('Error', 'Could not find the form to submit', 'error');
            }
        }
    });
};

// Ensure buttons are properly initialized
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing post buttons');
    
    // Add click event listeners to buttons as backup
    const buttons = document.querySelectorAll('.post .actions button, .post .actions a');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            console.log('Button clicked:', this.className, this.onclick);
            
            // For delete buttons, ensure they work
            if (this.className.includes('delete') && this.onclick) {
                // Allow the onclick to handle it
                return;
            }
            
            // For other buttons, ensure they're clickable
            if (this.disabled) {
                e.preventDefault();
                console.log('Button is disabled');
            }
        });
    });
    
    // Check for any missing forms
    const deleteForms = document.querySelectorAll('form[id^="delete_form_"]');
    const highlightForms = document.querySelectorAll('form[id^="highlight_form_"]');
    
    console.log('Found delete forms:', deleteForms.length);
    console.log('Found highlight forms:', highlightForms.length);
});

// Add error handling for form submissions
window.handleFormSubmit = function(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.submit();
    } else {
        console.error('Form not found:', formId);
        if (typeof cannot === 'function') {
            cannot('Form not found. Please refresh the page and try again.');
        } else {
            alert('Form not found. Please refresh the page and try again.');
        }
    }
};
