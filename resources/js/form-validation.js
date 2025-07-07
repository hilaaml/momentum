/**
 * Form validation script for Momentum
 * Handles image file size validation and content field validation
 */
document.addEventListener('DOMContentLoaded', function() {
    // File size validation for images
    validateImageFileSize();
    
    // Content field validation
    validateContentField();
    
    // Form submission validation
    validateFormSubmission();
});

/**
 * Validates image file size
 */
function validateImageFileSize() {
    document.querySelectorAll('input[type="file"][name="image"]').forEach(function(input) {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            
            // Clear previous error message if any
            const parent = this.parentElement;
            const existingError = parent.querySelector('.file-size-error');
            if (existingError) {
                existingError.remove();
            }
            
            if (file && file.size > maxSize) {
                // Create error message
                const errorMsg = document.createElement('p');
                errorMsg.className = 'text-red-500 text-xs mt-1 file-size-error';
                errorMsg.textContent = 'The image must not be larger than 5MB';
                
                // Insert after the input
                this.insertAdjacentElement('afterend', errorMsg);
                
                // Reset the input
                this.value = '';
            }
        });
    });
}

/**
 * Validates content textarea fields
 */
function validateContentField() {
    document.querySelectorAll('textarea[name="content"]').forEach(function(textarea) {
        // Initial validation on page load
        validateTextarea(textarea);
        
        // Validate on input
        textarea.addEventListener('input', function() {
            validateTextarea(this);
        });
        
        // Validate on blur
        textarea.addEventListener('blur', function() {
            validateTextarea(this, true);
        });
    });
}

/**
 * Validates textarea content
 * @param {HTMLElement} textarea - The textarea element to validate
 * @param {boolean} showError - Whether to show error message
 */
function validateTextarea(textarea, showError = false) {
    const parent = textarea.parentElement;
    const existingError = parent.querySelector('.content-error');
    
    if (existingError) {
        existingError.remove();
    }
    
    if (!textarea.value.trim() && showError) {
        const errorMsg = document.createElement('p');
        errorMsg.className = 'text-red-500 text-xs mt-1 content-error';
        errorMsg.textContent = 'The content field is required';
        textarea.insertAdjacentElement('afterend', errorMsg);
    }
}

/**
 * Validates form on submission
 */
function validateFormSubmission() {
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const contentTextarea = this.querySelector('textarea[name="content"]');
            if (contentTextarea && !contentTextarea.value.trim()) {
                e.preventDefault();
                validateTextarea(contentTextarea, true);
            }
        });
    });
} 