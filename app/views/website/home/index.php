<?php
/**
 * Homepage View
 * Displays hero, featured posts, and recent posts
 */

// Start output buffering to capture content
ob_start();
?>

<!-- Hero Section -->
<?php require_once BASE_PATH . '/app/views/website/partials/hero.php'; ?>

<!-- Featured Posts Section -->
<section class="py-16 bg-light">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-display text-4xl font-bold text-primary mb-4">Featured Posts</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Hand-picked stories that we think you'll love</p>
        </div>
        
        <?php if (empty($featuredPosts)): ?>
            <p class="text-center text-gray-500">No featured posts yet.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($featuredPosts as $post): ?>
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="<?= htmlspecialchars($post['cover_image_url'] ?? '/blog-post/public/images/placeholder.jpg') ?>" 
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            >
                            <div class="absolute top-4 left-4">
                                <span class="bg-accent text-white text-xs px-3 py-1 rounded-full font-semibold">
                                    Featured
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span><?= htmlspecialchars($post['category'] ?? 'General') ?></span>
                                <span class="mx-2">•</span>
                                <span><?= $post['reading_time_min'] ?? 5 ?> min read</span>
                            </div>
                            <h3 class="font-display text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors">
                                <a href="/blog-post/posts/<?= htmlspecialchars($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                <?= htmlspecialchars($post['excerpt'] ?? '') ?>
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    By <?= htmlspecialchars($post['author_name'] ?? 'Admin') ?>
                                </span>
                                <span class="text-sm text-gray-400">
                                    <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Recent Posts Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-display text-4xl font-bold text-primary mb-4">Recent Posts</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay up to date with our latest articles</p>
        </div>
        
        <?php if (empty($recentPosts)): ?>
            <p class="text-center text-gray-500">No posts yet. Check back soon!</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($recentPosts as $post): ?>
                    <article class="bg-light rounded-xl overflow-hidden group hover:shadow-lg transition-all duration-300">
                        <div class="relative h-40 overflow-hidden">
                            <img 
                                src="<?= htmlspecialchars($post['cover_image_url'] ?? '/blog-post/public/images/placeholder.jpg') ?>" 
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute top-3 right-3">
                                <span class="bg-primary/80 text-white text-xs px-2 py-1 rounded">
                                    <?= htmlspecialchars($post['category'] ?? 'General') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-bold text-primary mb-2 group-hover:text-accent transition-colors line-clamp-2">
                                <a href="/blog-post/posts/<?= htmlspecialchars($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                <?= htmlspecialchars($post['excerpt'] ?? '') ?>
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span><?= $post['views'] ?? 0 ?> views</span>
                                </div>
                                <span><?= date('M d', strtotime($post['created_at'])) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="/blog-post/posts" class="inline-block bg-primary hover:bg-secondary text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200">
                    View All Posts
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>

