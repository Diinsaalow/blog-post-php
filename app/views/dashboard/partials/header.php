<?php
/**
 * Dashboard Header Partial
 */
Session::start();
$username = Session::get('username', 'Admin');
?>

<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Page Title -->
        <div>
            <h1 class="font-display text-2xl font-bold text-primary">
                <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>
            </h1>
        </div>
        
        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button class="flex items-center space-x-3 text-gray-600 hover:text-primary transition-colors">
                    <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white font-bold">
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    </div>
                    <span class="font-medium"><?= htmlspecialchars($username) ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
            <!-- Logout -->
            <a href="/blog-post/logout" 
               class="flex items-center space-x-2 text-gray-500 hover:text-red-600 transition-colors"
               title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </div>
</header>

