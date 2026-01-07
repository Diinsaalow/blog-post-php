<?php
/**
 * Posts by Category View
 */

ob_start();
?>

<section class="py-16 bg-light min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="bg-accent text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 inline-block">
                Category
            </span>
            <h1 class="font-display text-4xl font-bold text-primary mb-4">
                <?= htmlspecialchars(ucfirst($category)) ?>
            </h1>
            <p class="text-gray-600">All posts in this category</p>
        </div>
        
        <?php if (empty($posts)): ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No posts found in this category.</p>
                <a href="/blog-post/posts" class="text-accent hover:underline mt-4 inline-block">
                    Browse all posts
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="<?= htmlspecialchars($post['cover_image_url'] ?? '/blog-post/public/images/placeholder.jpg') ?>" 
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                        </div>
                        <div class="p-6">
                            <h2 class="font-display text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors line-clamp-2">
                                <a href="/blog-post/posts/<?= htmlspecialchars($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                <?= htmlspecialchars($post['excerpt'] ?? '') ?>
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></span>
                                <span><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>

