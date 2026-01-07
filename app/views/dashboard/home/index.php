<?php
/**
 * Dashboard Home View
 */

ob_start();
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Posts Card -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Posts</p>
                <p class="text-3xl font-bold text-primary mt-1"><?= $totalPosts ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
        </div>
        <a href="/blog-post/dashboard/posts" class="text-accent text-sm hover:underline mt-4 inline-block">
            View all posts →
        </a>
    </div>
    
    <!-- Users Card -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Users</p>
                <p class="text-3xl font-bold text-primary mt-1"><?= $totalUsers ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <a href="/blog-post/dashboard/users" class="text-accent text-sm hover:underline mt-4 inline-block">
            Manage users →
        </a>
    </div>
    
    <!-- Comments Card -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Comments</p>
                <p class="text-3xl font-bold text-primary mt-1"><?= $totalComments ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
        </div>
        <a href="/blog-post/dashboard/comments" class="text-accent text-sm hover:underline mt-4 inline-block">
            View comments →
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-primary">Recent Posts</h2>
            <a href="/blog-post/dashboard/posts/create" class="text-accent text-sm hover:underline">
                + New Post
            </a>
        </div>
        
        <?php if (empty($recentPosts)): ?>
            <p class="text-gray-500 text-center py-8">No posts yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="flex items-center space-x-4 p-3 bg-light rounded-lg">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-primary truncate"><?= htmlspecialchars($post['title']) ?></p>
                            <p class="text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                <?php if ($post['is_featured']): ?>
                                    <span class="ml-2 text-xs bg-accent/10 text-accent px-2 py-0.5 rounded">Featured</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <a href="/blog-post/dashboard/posts/<?= $post['id'] ?>/edit" class="text-gray-400 hover:text-accent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Recent Comments -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-primary">Recent Comments</h2>
            <a href="/blog-post/dashboard/comments" class="text-accent text-sm hover:underline">
                View all →
            </a>
        </div>
        
        <?php if (empty($recentComments)): ?>
            <p class="text-gray-500 text-center py-8">No comments yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($recentComments as $comment): ?>
                    <div class="p-3 bg-light rounded-lg">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                <?= strtoupper(substr($comment['author_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-primary text-sm">
                                    <?= htmlspecialchars($comment['author_name'] ?? 'User') ?>
                                </p>
                                <p class="text-gray-600 text-sm truncate">
                                    <?= htmlspecialchars(substr($comment['content'], 0, 80)) ?>...
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    on "<?= htmlspecialchars(substr($comment['post_title'] ?? '', 0, 30)) ?>..."
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/dashboard/layouts/main.php';
?>

