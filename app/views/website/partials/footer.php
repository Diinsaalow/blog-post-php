<?php
/**
 * Website Footer Partial
 */
?>

<footer class="bg-primary text-white mt-auto">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <span class="font-display text-2xl font-bold text-accent">Blog</span>
                    <span class="font-display text-2xl font-light">Post</span>
                </div>
                <p class="text-gray-400 text-sm">
                    A modern blogging platform where ideas come to life. Share your thoughts, discover new perspectives.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="font-display text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="/blog-post/" class="hover:text-accent transition-colors">Home</a></li>
                    <li><a href="/blog-post/posts" class="hover:text-accent transition-colors">All Posts</a></li>
                    <li><a href="/blog-post/login" class="hover:text-accent transition-colors">Login</a></li>
                    <li><a href="/blog-post/register" class="hover:text-accent transition-colors">Register</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div>
                <h3 class="font-display text-lg font-semibold mb-4">Categories</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="/blog-post/posts/category/technology" class="hover:text-accent transition-colors">Technology</a></li>
                    <li><a href="/blog-post/posts/category/lifestyle" class="hover:text-accent transition-colors">Lifestyle</a></li>
                    <li><a href="/blog-post/posts/category/travel" class="hover:text-accent transition-colors">Travel</a></li>
                    <li><a href="/blog-post/posts/category/food" class="hover:text-accent transition-colors">Food</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; <?= date('Y') ?> Blog Post Application. All rights reserved.</p>
        </div>
    </div>
</footer>

