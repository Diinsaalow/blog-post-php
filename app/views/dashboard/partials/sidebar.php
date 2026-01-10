<?php
require_once BASE_PATH . '/app/helpers/functions.php';
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/blog-post/dashboard';

function isActive(string $path, string $currentPath): bool {
    return strpos($currentPath, $path) !== false;
}
?>

<aside class="w-64 bg-gray-900 text-white flex flex-col shadow-lg">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-800">
        <a href="<?= url('/dashboard') ?>" class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-blue-400">BLOGGIES</span>
            <span class="text-xs text-gray-400 px-2 py-0.5 bg-gray-800 rounded">Admin</span>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="<?= url('/dashboard') ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= $currentPath === $basePath || $currentPath === $basePath . '/' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- Posts -->
            <li>
                <a href="<?= url('/dashboard/posts') ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/posts', $currentPath) ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span>Posts</span>
                </a>
            </li>
            
            <!-- Users -->
            <li>
                <a href="<?= url('/dashboard/users') ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/users', $currentPath) ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Users</span>
                </a>
            </li>
            
            <!-- Comments -->
            <li>
                <a href="<?= url('/dashboard/comments') ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/comments', $currentPath) ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    <span>Comments</span>
                </a>
            </li>
        </ul>
        
        <!-- Separator -->
        <div class="border-t border-gray-800 my-6"></div>
        
        <!-- Quick Links -->
        <ul class="space-y-2">
            <li>
                <a href="<?= url('/') ?>" target="_blank"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-colors">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    <span>View Website</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Footer -->
    <div class="p-4 border-t border-gray-800">
        <p class="text-gray-500 text-xs text-center">
            &copy; <?= date('Y') ?> BLOGGIES
        </p>
    </div>
</aside>
