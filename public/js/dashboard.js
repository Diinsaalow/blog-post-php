/**
 * BLOGGIES - Dashboard JavaScript
 * Handles dashboard interactions and UI enhancements
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons ONCE after DOM is ready
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Sidebar toggle for mobile (if needed)
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
    
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.opacity = '0';
            message.style.transition = 'opacity 0.5s ease';
            setTimeout(function() {
                message.remove();
            }, 500);
        }, 5000);
    });
    
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 'Are you sure you want to delete this?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                } else {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Character counter for inputs with maxlength
    const limitedInputs = document.querySelectorAll('input[maxlength], textarea[maxlength]');
    limitedInputs.forEach(function(input) {
        const maxLength = parseInt(input.getAttribute('maxlength'));
        const hint = input.parentNode.querySelector('.text-xs');
        
        if (hint && hint.textContent.includes('characters')) {
            input.addEventListener('input', function() {
                const remaining = maxLength - this.value.length;
                hint.textContent = `${this.value.length}/${maxLength} characters`;
                
                if (remaining < 20) {
                    hint.classList.add('text-red-500');
                    hint.classList.remove('text-gray-400');
                } else {
                    hint.classList.remove('text-red-500');
                    hint.classList.add('text-gray-400');
                }
            });
        }
    });
    
    // Image preview for URL inputs
    const imageUrlInputs = document.querySelectorAll('input[name="cover_image_url"]');
    imageUrlInputs.forEach(function(input) {
        let preview = input.parentNode.querySelector('#image-preview');
        
        if (!preview) {
            preview = document.createElement('div');
            preview.id = 'image-preview';
            preview.className = 'mt-2 hidden';
            preview.innerHTML = '<img src="" alt="Preview" class="w-32 h-20 object-cover rounded border border-gray-200">';
            input.parentNode.appendChild(preview);
        }
        
        input.addEventListener('input', function() {
            const url = this.value.trim();
            if (url) {
                const img = preview.querySelector('img');
                img.src = url;
                img.onload = function() {
                    preview.classList.remove('hidden');
                };
                img.onerror = function() {
                    preview.classList.add('hidden');
                };
            } else {
                preview.classList.add('hidden');
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                // Trigger search after user stops typing
                const form = searchInput.closest('form');
                if (form) {
                    form.submit();
                }
            }, 500);
        });
    }
    
    // Table row hover effects - using CSS classes instead of inline styles
    // This is handled by Tailwind's hover:bg-gray-50 class, so we can remove this
});
