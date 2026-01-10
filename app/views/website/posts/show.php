<?php
require_once BASE_PATH . '/app/helpers/functions.php';
require_once BASE_PATH . '/core/Session.php';

$isLoggedIn = Session::isLoggedIn();
$isAdmin = Session::isAdmin();
$userId = Session::userId();

ob_start();
?>

<main class="pt-16">
    <!-- Blog title and cover image -->
    <div class="relative h-[50vh] sm:h-[60vh] bg-gray-100">
        <!-- Navigation buttons -->
        <div class="absolute top-0 left-0 right-0 p-6 md:p-8 max-w-4xl mx-auto z-10">
            <div class="flex items-center justify-between">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium border border-white/30 bg-white/10 backdrop-blur-sm text-white rounded-md hover:bg-white/20 transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                    Back
                </a>

                <?php if ($isAdmin): ?>
                    <div class="flex items-center space-x-2">
                        <a href="<?= url('/dashboard/posts/' . $post['id'] . '/edit') ?>" 
                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                            Edit
                        </a>
                        <form action="<?= url('/dashboard/posts/' . $post['id'] . '/delete') ?>" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Cover Image -->
        <img src="<?= e($post['cover_image_url'] ?? 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?auto=format&fit=crop&q=80') ?>" 
             alt="<?= e($post['title']) ?>"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20"></div>

        <!-- Post Meta -->
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 max-w-4xl mx-auto">
            <?php if (!empty($post['category'])): ?>
                <span class="tag bg-white/10 backdrop-blur-sm text-white mb-4">
                    <?= e($post['category']) ?>
                </span>
            <?php endif; ?>
            
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                <?= e($post['title']) ?>
            </h1>
            
            <div class="flex items-center flex-wrap gap-4 text-white">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full overflow-hidden mr-2 bg-gray-300">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($post['author_name'] ?? 'User') ?>&background=3b82f6&color=fff" 
                             alt="<?= e($post['author_name'] ?? 'Unknown') ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <span><?= e($post['author_name'] ?? 'Unknown') ?></span>
                </div>
                <div class="flex items-center">
                    <i data-lucide="calendar-days" class="w-4 h-4 mr-1"></i>
                    <span><?= formatDate($post['created_at']) ?></span>
                </div>
                <div class="flex items-center">
                    <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                    <span><?= $post['reading_time_min'] ?? readingTime($post['content']) ?> min read</span>
                </div>
                <div class="flex items-center">
                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i>
                    <span><?= number_format($post['views'] ?? 0) ?> views</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="prose prose-lg max-w-none">
            <?= nl2br(e($post['content'])) ?>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200">
        <h2 class="text-2xl font-bold mb-6">Comments (<?= $commentCount ?? 0 ?>)</h2>

        <!-- Add new comment form -->
        <form action="<?= url('/posts/' . $post['id'] . '/comments') ?>" method="POST" class="mb-8">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 bg-gray-200">
                    <?php if ($isLoggedIn): ?>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode(Session::get('username', 'User')) ?>&background=3b82f6&color=fff" 
                             alt="Your avatar"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">
                            <i data-lucide="user" class="w-5 h-5 text-gray-500"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <textarea name="content" 
                              placeholder="<?= $isLoggedIn ? 'Write a comment...' : 'Login to write a comment...' ?>"
                              class="w-full min-h-[100px] p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              <?= !$isLoggedIn ? 'disabled' : '' ?>></textarea>
                    <div class="flex justify-end mt-2">
                        <?php if ($isLoggedIn): ?>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                                Post Comment
                            </button>
                        <?php else: ?>
                            <a href="<?= url('/login') ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                Login to Comment
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <!-- Comments list -->
        <div class="space-y-6">
            <?php if (empty($comments)): ?>
                <div class="text-center text-gray-500 py-8">
                    <i data-lucide="message-circle" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    <p>No comments yet. Be the first to comment!</p>
                </div>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                <img src="<?= e($comment['avatar_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment['author_name'] ?? 'User') . '&background=6366f1&color=fff') ?>" 
                                     alt="<?= e($comment['author_name'] ?? 'Unknown') ?>"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-900">
                                            <?= e($comment['author_name'] ?? 'Unknown') ?>
                                        </span>
                                        <span class="text-gray-500 text-sm ml-2">
                                            <?= timeAgo($comment['created_at']) ?>
                                        </span>
                                    </div>
                                    
                                    <?php if ($isLoggedIn && ($userId === $comment['author_id'] || $isAdmin)): ?>
                                        <form action="<?= url('/dashboard/comments/' . $comment['id'] . '/delete') ?>" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                            <button type="submit" 
                                                    class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors"
                                                    title="Delete comment">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <p class="text-gray-700 whitespace-pre-wrap"><?= e($comment['content']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>
