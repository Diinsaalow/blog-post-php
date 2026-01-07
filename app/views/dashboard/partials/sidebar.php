<?php
/**
 * Dashboard Sidebar Partial
 */
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/blog-post/dashboard';

/**
 * Check if menu item is active
 */
function isActive(string $path, string $currentPath): bool
{
    return strpos($currentPath, $path) !== false;
}
?>

<aside class="w-64 bg-sidebar text-white flex flex-col">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-800">
        <a href="/blog-post/dashboard" class="flex items-center space-x-2">
            <span class="font-display text-2xl font-bold text-accent">Blog</span>
            <span class="font-display text-2xl font-light">Admin</span>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="<?= $basePath ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= $currentPath === $basePath || $currentPath === $basePath . '/' ? 'bg-accent text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- Posts -->
            <li>
                <a href="<?= $basePath ?>/posts" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/posts', $currentPath) ? 'bg-accent text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Posts</span>
                </a>
            </li>
            
            <!-- Users -->
            <li>
                <a href="<?= $basePath ?>/users" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/users', $currentPath) ? 'bg-accent text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Users</span>
                </a>
            </li>
            
            <!-- Comments -->
            <li>
                <a href="<?= $basePath ?>/comments" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors <?= isActive($basePath . '/comments', $currentPath) ? 'bg-accent text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Comments</span>
                </a>
            </li>
        </ul>
        
        <!-- Separator -->
        <div class="border-t border-gray-800 my-6"></div>
        
        <!-- Quick Links -->
        <ul class="space-y-2">
            <li>
                <a href="/blog-post/" target="_blank"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>View Website</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Footer -->
    <div class="p-4 border-t border-gray-800">
        <p class="text-gray-500 text-xs text-center">
            &copy; <?= date('Y') ?> Blog Post Admin
        </p>
    </div>
</aside>

