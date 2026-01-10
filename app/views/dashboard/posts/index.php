<?php
require_once BASE_PATH . '/app/helpers/functions.php';
require_once BASE_PATH . '/core/Session.php';
ob_start();
?>

<!-- Header Actions -->
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-500">Manage all blog posts</p>
    </div>
    <a href="<?= url('/dashboard/posts/create') ?>" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm">
        <i data-lucide="plus" class="w-5 h-5"></i>
        <span>New Post</span>
    </a>
</div>

<!-- Posts Table -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if (empty($posts)): ?>
        <div class="text-center py-12">
            <i data-lucide="file-text" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
            <p class="text-gray-500">No posts yet. Create your first post!</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Title</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Views</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                        <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <?php if ($post['is_featured']): ?>
                                        <i data-lucide="star" class="w-4 h-4 text-yellow-500 fill-yellow-500" title="Featured"></i>
                                    <?php endif; ?>
                                    <span class="font-medium text-gray-900"><?= htmlspecialchars(substr($post['title'], 0, 50)) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600"><?= htmlspecialchars($post['category'] ?? 'General') ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($post['is_published']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Published</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600"><?= number_format($post['views'] ?? 0) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500"><?= formatDate($post['created_at']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Toggle Featured -->
                                    <form action="<?= url('/dashboard/posts/' . $post['id'] . '/toggle-featured') ?>" method="POST" class="inline">
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-yellow-500 transition-colors" 
                                                title="<?= $post['is_featured'] ? 'Remove from featured' : 'Mark as featured' ?>">
                                            <i data-lucide="<?= $post['is_featured'] ? 'star' : 'star' ?>" class="w-5 h-5 <?= $post['is_featured'] ? 'fill-yellow-500 text-yellow-500' : '' ?>"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Edit -->
                                    <a href="<?= url('/dashboard/posts/' . $post['id'] . '/edit') ?>" 
                                       class="p-2 text-gray-400 hover:text-blue-600 transition-colors" 
                                       title="Edit">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                    
                                    <!-- Delete -->
                                    <form action="<?= url('/dashboard/posts/' . $post['id'] . '/delete') ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
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
