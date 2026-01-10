<?php
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/helpers/functions.php';

$isLoggedIn = Session::isLoggedIn();
$isAdmin = Session::isAdmin();
$username = Session::get('username', '');
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path for route matching
$route = str_replace('/blog-post', '', $currentPath);
?>

<nav id="navbar" class="fixed top-0 w-full z-30 transition-all duration-300 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?= url('/') ?>" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors">
                    BLOGGIES
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="flex items-center space-x-4">
                    <a href="<?= url('/') ?>" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= $route === '/' ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
                        Home
                    </a>
                    
                    <a href="<?= url('/posts') ?>" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= str_starts_with($route, '/posts') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
                        Blogs
                    </a>
                    
                    <?php if ($isAdmin): ?>
                        <a href="<?= url('/dashboard/posts/create') ?>" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            <i data-lucide="pen-square" class="w-4 h-4"></i>
                            Add New Blog
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($isLoggedIn): ?>
                        <?php if ($isAdmin): ?>
                            <a href="<?= url('/dashboard') ?>" 
                               class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                                Dashboard
                            </a>
                        <?php endif; ?>
                        
                        <span class="text-sm text-gray-500">
                            Hi, <?= e($username) ?>
                        </span>
                        
                        <a href="<?= url('/logout') ?>" 
                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/login') ?>" 
                           class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                            Sign In
                        </a>
                        
                        <a href="<?= url('/register') ?>" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" id="mobile-menu-btn" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-blue-600 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                    <i data-lucide="x" class="w-6 h-6 hidden" id="close-icon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white/95 shadow-lg backdrop-blur-md animate-fade-in">
            <a href="<?= url('/') ?>" 
               class="block px-3 py-2 rounded-md text-base font-medium <?= $route === '/' ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
                Home
            </a>
            
            <a href="<?= url('/posts') ?>" 
               class="block px-3 py-2 rounded-md text-base font-medium <?= str_starts_with($route, '/posts') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
                Blogs
            </a>
            
            <?php if ($isAdmin): ?>
                <a href="<?= url('/dashboard/posts/create') ?>" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600">
                    Write a Blog
                </a>
            <?php endif; ?>
            
            <div class="pt-4 flex flex-col space-y-2 px-3">
                <?php if ($isLoggedIn): ?>
                    <?php if ($isAdmin): ?>
                        <a href="<?= url('/dashboard') ?>" 
                           class="w-full text-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Dashboard
                        </a>
                    <?php endif; ?>
                    <a href="<?= url('/logout') ?>" 
                       class="w-full text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= url('/login') ?>" 
                       class="w-full text-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Sign In
                    </a>
                    <a href="<?= url('/register') ?>" 
                       class="w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Sign Up
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    // Scroll effect for navbar
    window.addEventListener('scroll', function() {
        if (window.scrollY > 10) {
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
        } else {
            navbar.classList.add('bg-transparent');
            navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
        }
    });
    
    // Mobile menu toggle
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
});
</script>
