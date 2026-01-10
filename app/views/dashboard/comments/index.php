<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<!-- Header -->
<div class="mb-6">
    <p class="text-gray-500">Manage all comments on blog posts</p>
</div>

<!-- Comments Table -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if (empty($comments)): ?>
        <div class="text-center py-12">
            <i data-lucide="message-circle" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
            <p class="text-gray-500">No comments yet.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
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
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                        <?= strtoupper(substr($comment['author_name'] ?? 'U', 0, 1)) ?>
                                    </div>
                                    <span class="font-medium text-gray-900"><?= htmlspecialchars($comment['author_name'] ?? 'User') ?></span>
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
                                <span class="text-sm text-gray-500"><?= formatDate($comment['created_at']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end">
                                    <!-- Delete -->
                                    <form action="<?= url('/dashboard/comments/' . $comment['id'] . '/delete') ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/dashboard/layouts/main.php';
?>
