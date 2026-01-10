<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Posts Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Posts</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalPosts ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
        <a href="<?= url('/dashboard/posts') ?>" class="text-blue-600 text-sm hover:underline mt-4 inline-block">
            View all posts →
        </a>
    </div>
    
    <!-- Users Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalUsers ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-green-600"></i>
            </div>
        </div>
        <a href="<?= url('/dashboard/users') ?>" class="text-blue-600 text-sm hover:underline mt-4 inline-block">
            Manage users →
        </a>
    </div>
    
    <!-- Comments Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Comments</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalComments ?? 0 ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i data-lucide="message-circle" class="w-6 h-6 text-purple-600"></i>
            </div>
        </div>
        <a href="<?= url('/dashboard/comments') ?>" class="text-blue-600 text-sm hover:underline mt-4 inline-block">
            View comments →
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Recent Posts</h2>
            <a href="<?= url('/dashboard/posts/create') ?>" class="inline-flex items-center gap-1.5 text-blue-600 text-sm hover:underline">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Post
            </a>
        </div>
        
        <?php if (empty($recentPosts)): ?>
            <p class="text-gray-500 text-center py-8">No posts yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate"><?= htmlspecialchars($post['title']) ?></p>
                            <p class="text-sm text-gray-500">
                                <?= formatDate($post['created_at']) ?>
                                <?php if ($post['is_featured']): ?>
                                    <span class="ml-2 text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Featured</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <a href="<?= url('/dashboard/posts/' . $post['id'] . '/edit') ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                            <i data-lucide="edit" class="w-5 h-5"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Recent Comments -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Recent Comments</h2>
            <a href="<?= url('/dashboard/comments') ?>" class="text-blue-600 text-sm hover:underline">
                View all →
            </a>
        </div>
        
        <?php if (empty($recentComments)): ?>
            <p class="text-gray-500 text-center py-8">No comments yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($recentComments as $comment): ?>
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                <?= strtoupper(substr($comment['author_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm">
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
