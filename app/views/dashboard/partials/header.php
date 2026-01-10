<?php
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/helpers/functions.php';

$username = Session::get('username', 'Admin');
?>

<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>
            </h1>
        </div>
        
        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- User Info -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    <?= strtoupper(substr($username, 0, 1)) ?>
                </div>
                <span class="font-medium text-gray-700 hidden md:block"><?= htmlspecialchars($username) ?></span>
            </div>
            
            <!-- Logout -->
            <a href="<?= url('/logout') ?>" 
               class="inline-flex items-center space-x-2 px-3 py-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
               title="Logout">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="hidden md:inline">Logout</span>
            </a>
        </div>
    </div>
</header>
