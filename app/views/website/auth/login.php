<?php
/**
 * Login View
 */

ob_start();
?>

<section class="min-h-screen bg-gradient-to-br from-primary to-secondary flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <a href="/blog-post/" class="inline-block mb-4">
                    <span class="font-display text-3xl font-bold text-accent">Blog</span>
                    <span class="font-display text-3xl font-light text-primary">Post</span>
                </a>
                <h1 class="font-display text-2xl font-bold text-primary">Welcome Back</h1>
                <p class="text-gray-500 mt-2">Sign in to your account</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form action="/blog-post/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        placeholder="you@example.com"
                    >
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        placeholder="••••••••"
                    >
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-accent hover:bg-red-600 text-white py-3 rounded-lg font-semibold transition-colors duration-200"
                >
                    Sign In
                </button>
            </form>
            
            <p class="text-center text-gray-500 mt-6">
                Don't have an account? 
                <a href="/blog-post/register" class="text-accent hover:underline font-semibold">Register</a>
            </p>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>

