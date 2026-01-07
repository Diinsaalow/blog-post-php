<?php
/**
 * Website Header Partial
 */

// Ensure session is started and get values
Session::start();
$isLoggedIn = Session::isLoggedIn();
$username = Session::get('username', '');
$userRole = Session::get('user_role', '');
$isAdmin = ($userRole === 'admin');
?>

<header class="bg-primary text-white shadow-lg sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="/blog-post/" class="flex items-center space-x-2">
                <span class="font-display text-2xl font-bold text-accent">Blog</span>
                <span class="font-display text-2xl font-light">Post</span>
            </a>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/blog-post/" class="hover:text-accent transition-colors duration-200">Home</a>
                <a href="/blog-post/posts" class="hover:text-accent transition-colors duration-200">Posts</a>
            </div>
            
            <!-- Auth Buttons -->
            <div class="flex items-center space-x-4">
                <?php if ($isLoggedIn): ?>
                    <span class="text-gray-300">Hello, <?= htmlspecialchars($username) ?></span>
                    <?php if ($isAdmin): ?>
                        <a href="/blog-post/dashboard" class="bg-accent hover:bg-red-600 px-4 py-2 rounded-lg transition-colors duration-200">
                            Dashboard
                        </a>
                    <?php endif; ?>
                    <a href="/blog-post/logout" class="border border-white hover:bg-white hover:text-primary px-4 py-2 rounded-lg transition-colors duration-200">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/blog-post/login" class="hover:text-accent transition-colors duration-200">Login</a>
                    <a href="/blog-post/register" class="bg-accent hover:bg-red-600 px-4 py-2 rounded-lg transition-colors duration-200">
                        Register
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-600 pt-4">
            <div class="flex flex-col space-y-4">
                <a href="/blog-post/" class="hover:text-accent transition-colors duration-200">Home</a>
                <a href="/blog-post/posts" class="hover:text-accent transition-colors duration-200">Posts</a>
                <?php if (!$isLoggedIn): ?>
                    <a href="/blog-post/login" class="hover:text-accent transition-colors duration-200">Login</a>
                    <a href="/blog-post/register" class="hover:text-accent transition-colors duration-200">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

