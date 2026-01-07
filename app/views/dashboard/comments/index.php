<?php
/**
 * Dashboard Comments Index View
 */

ob_start();
?>

<!-- Header -->
<div class="mb-6">
    <p class="text-gray-500">Manage all comments on blog posts</p>
</div>

<!-- Flash Messages -->
<?php if (!empty($success)): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<!-- Comments Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <?php if (empty($comments)): ?>
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p class="text-gray-500">No comments yet.</p>
        </div>
    <?php else: ?>
        <table class="w-full">
            <thead class="bg-light border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Author</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Comment</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Post</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($comments as $comment): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    <?= strtoupper(substr($comment['author_name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <span class="font-medium text-primary"><?= htmlspecialchars($comment['author_name'] ?? 'User') ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">
                                <?= htmlspecialchars(substr($comment['content'], 0, 100)) ?><?= strlen($comment['content']) > 100 ? '...' : '' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500"><?= htmlspecialchars(substr($comment['post_title'] ?? '', 0, 40)) ?>...</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($comment['created_at'])) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end">
                                <!-- Delete -->
                                <form action="/blog-post/dashboard/comments/<?= $comment['id'] ?>/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/dashboard/layouts/main.php';
?>

