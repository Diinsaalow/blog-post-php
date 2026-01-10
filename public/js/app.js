/**
 * Bloggies - Main JavaScript
 * Handles UI interactions and animations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons if available
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Animate elements on scroll
    initScrollAnimations();
    
    // Handle form validations
    initFormValidations();
    
    // Image lazy loading fallback
    initImageFallbacks();
});

/**
 * Initialize scroll-based animations
 */
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-fade-in');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(el);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        animatedElements.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });
    }
}

/**
 * Initialize form validations
 */
function initFormValidations() {
    // Password confirmation validation
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordInput = document.getElementById('password');
    
    if (confirmPasswordInput && passwordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        
        passwordInput.addEventListener('input', function() {
            if (confirmPasswordInput.value && this.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    }
    
    // Comment form validation
    const commentForm = document.querySelector('form[action*="/comments"]');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            const textarea = this.querySelector('textarea[name="content"]');
            if (textarea && !textarea.value.trim()) {
                e.preventDefault();
                textarea.focus();
                showToast('Please enter a comment', 'error');
            }
        });
    }
}

/**
 * Initialize image fallbacks
 */
function initImageFallbacks() {
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        img.addEventListener('error', function() {
            // Replace with a placeholder if image fails to load
            this.src = 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?auto=format&fit=crop&q=80&w=400';
            this.alt = 'Image unavailable';
        });
    });
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    // Remove existing toast
    const existingToast = document.getElementById('js-toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    const bgColor = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500',
        'warning': 'bg-yellow-500'
    }[type] || 'bg-blue-500';
    
    const icon = {
        'success': 'check-circle',
        'error': 'x-circle',
        'info': 'info',
        'warning': 'alert-triangle'
    }[type] || 'info';
    
    const toast = document.createElement('div');
    toast.id = 'js-toast';
    toast.className = `fixed top-4 left-1/2 transform -translate-x-1/2 z-50 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in`;
    toast.innerHTML = `
        <i data-lucide="${icon}" class="w-5 h-5"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    // Initialize icon in toast
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Auto-remove after 4 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(-100%)';
        toast.style.transition = 'all 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

/**
 * Confirm delete action
 */
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this item?');
}

/**
 * Handle search form
 */
function handleSearch(event) {
    const form = event.target.closest('form');
    const input = form.querySelector('input[name="search"]');
    
    if (!input.value.trim()) {
        event.preventDefault();
        input.focus();
    }
}

/**
 * Toggle mobile menu (backup for inline script)
 */
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (mobileMenu && menuIcon && closeIcon) {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }
}

/**
 * Smooth scroll to element
 */
function scrollToElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Expose functions globally if needed
window.showToast = showToast;
window.confirmDelete = confirmDelete;
window.toggleMobileMenu = toggleMobileMenu;
window.scrollToElement = scrollToElement;
