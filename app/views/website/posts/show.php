<?php
/**
 * Single Post View
 * Displays a single blog post with comments
 */

ob_start();
?>

<article class="py-12 bg-light min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Post Header -->
        <header class="mb-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                <a href="/blog-post/posts/category/<?= htmlspecialchars(strtolower($post['category'] ?? 'general')) ?>" 
                   class="bg-accent/10 text-accent px-3 py-1 rounded-full hover:bg-accent/20 transition-colors">
                    <?= htmlspecialchars($post['category'] ?? 'General') ?>
                </a>
                <span><?= $post['reading_time_min'] ?? 5 ?> min read</span>
                <span><?= $post['views'] ?? 0 ?> views</span>
            </div>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-primary mb-6 leading-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>
            <div class="flex items-center space-x-4 text-gray-600">
                <span>By <strong><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></strong></span>
                <span>•</span>
                <time><?= date('F d, Y', strtotime($post['created_at'])) ?></time>
            </div>
        </header>
        
        <!-- Cover Image -->
        <?php if (!empty($post['cover_image_url'])): ?>
            <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                <img 
                    src="<?= htmlspecialchars($post['cover_image_url']) ?>" 
                    alt="<?= htmlspecialchars($post['title']) ?>"
                    class="w-full h-auto"
                >
            </div>
        <?php endif; ?>
        
        <!-- Post Content -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-12 prose prose-lg max-w-none">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
        
        <!-- Comments Section -->
        <section class="bg-white rounded-xl shadow-md p-8">
            <h2 class="font-display text-2xl font-bold text-primary mb-6">
                Comments (<?= $commentCount ?>)
            </h2>
            
            <?php if (Session::isLoggedIn()): ?>
                <!-- Comment Form -->
                <form action="/blog-post/posts/<?= $post['id'] ?>/comments" method="POST" class="mb-8">
                    <textarea 
                        name="content" 
                        rows="4" 
                        placeholder="Write a comment..."
                        required
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent resize-none"
                    ></textarea>
                    <div class="flex justify-end mt-3">
                        <button type="submit" class="bg-accent hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Post Comment
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="bg-light rounded-lg p-4 mb-8 text-center">
                    <p class="text-gray-600">
                        <a href="/blog-post/login" class="text-accent hover:underline">Login</a> to leave a comment.
                    </p>
                </div>
            <?php endif; ?>
            
            <!-- Comments List -->
            <?php if (empty($comments)): ?>
                <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($comments as $comment): ?>
                        <div class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                                    <?= strtoupper(substr($comment['author_name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold text-primary">
                                            <?= htmlspecialchars($comment['author_name'] ?? 'User') ?>
                                        </span>
                                        <span class="text-sm text-gray-400">
                                            <?= date('M d, Y', strtotime($comment['created_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-gray-600">
                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</article>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>

