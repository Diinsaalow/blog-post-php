<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<div class="min-h-screen bg-white flex items-center justify-center">
    <div class="text-center px-4">
        <div class="mb-8">
            <i data-lucide="file-question" class="w-24 h-24 text-gray-300 mx-auto"></i>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            The page you're looking for doesn't exist or has been moved.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= url('/') ?>" 
               class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                Go Home
            </a>
            <a href="<?= url('/posts') ?>" 
               class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                <i data-lucide="book-open" class="w-4 h-4 mr-2"></i>
                Browse Blogs
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>
