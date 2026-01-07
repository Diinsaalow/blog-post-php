<?php
/**
 * Dashboard Posts Index View
 */

ob_start();
?>

<!-- Header Actions -->
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-500">Manage all blog posts</p>
    </div>
    <a href="/blog-post/dashboard/posts/create" 
       class="bg-accent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>New Post</span>
    </a>
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

<!-- Posts Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <?php if (empty($posts)): ?>
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-500">No posts yet. Create your first post!</p>
        </div>
    <?php else: ?>
        <table class="w-full">
            <thead class="bg-light border-b border-gray-200">
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
                                    <span class="text-yellow-500" title="Featured">★</span>
                                <?php endif; ?>
                                <span class="font-medium text-primary"><?= htmlspecialchars(substr($post['title'], 0, 50)) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600"><?= htmlspecialchars($post['category'] ?? 'General') ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($post['is_published']): ?>
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Published</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600"><?= $post['views'] ?? 0 ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Toggle Featured -->
                                <form action="/blog-post/dashboard/posts/<?= $post['id'] ?>/toggle-featured" method="POST" class="inline">
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-yellow-500 transition-colors" 
                                            title="<?= $post['is_featured'] ? 'Remove from featured' : 'Mark as featured' ?>">
                                        <svg class="w-5 h-5" fill="<?= $post['is_featured'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </button>
                                </form>
                                
                                <!-- Edit -->
                                <a href="/blog-post/dashboard/posts/<?= $post['id'] ?>/edit" 
                                   class="p-2 text-gray-400 hover:text-blue-600 transition-colors" 
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <!-- Delete -->
                                <form action="/blog-post/dashboard/posts/<?= $post['id'] ?>/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
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

