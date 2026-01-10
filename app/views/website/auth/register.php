<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<div class="min-h-screen bg-white">
    <main class="pt-28 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-12">
        <div class="flex flex-col items-center">
            <div class="w-full max-w-md">
                <!-- Auth Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm py-6">
                    <!-- Card Header -->
                    <div class="px-6 pb-6 text-center">
                        <h1 class="text-2xl font-semibold leading-none">Create an Account</h1>
                        <p class="text-gray-500 text-sm mt-1.5">
                            Fill in the details below to create your account
                        </p>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="px-6">
                        <?php if (!empty($error)): ?>
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md text-sm">
                                <?= e($error) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($success)): ?>
                            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm">
                                <?= e($success) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= url('/register') ?>" method="POST" class="space-y-4">
                            <!-- Username Field -->
                            <div class="grid gap-2">
                                <label for="username" class="text-sm font-medium">Username</label>
                                <input type="text" 
                                       id="username" 
                                       name="username" 
                                       placeholder="johndoe"
                                       required
                                       class="w-full h-9 px-3 py-1 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <!-- Email Field -->
                            <div class="grid gap-2">
                                <label for="email" class="text-sm font-medium">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       placeholder="your@email.com"
                                       required
                                       class="w-full h-9 px-3 py-1 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Password Field -->
                            <div class="grid gap-2">
                                <label for="password" class="text-sm font-medium">Password</label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••"
                                       required
                                       minlength="6"
                                       class="w-full h-9 px-3 py-1 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500">Must be at least 6 characters</p>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="grid gap-2">
                                <label for="confirm_password" class="text-sm font-medium">Confirm Password</label>
                                <input type="password" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       placeholder="••••••••"
                                       required
                                       class="w-full h-9 px-3 py-1 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full h-9 px-4 py-2 inline-flex items-center justify-center text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                Sign Up
                            </button>
                        </form>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="px-6 pt-6 flex justify-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="<?= url('/login') ?>" class="text-blue-600 hover:underline">
                                Sign in
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>
