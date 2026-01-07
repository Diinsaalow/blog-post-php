<?php
/**
 * Dashboard Users Index View
 */

ob_start();
?>

<!-- Header -->
<div class="mb-6">
    <p class="text-gray-500">Manage all registered users</p>
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

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <?php if (empty($users)): ?>
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <p class="text-gray-500">No users found.</p>
        </div>
    <?php else: ?>
        <table class="w-full">
            <thead class="bg-light border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">User</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Email</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Role</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Joined</th>
                    <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white font-bold">
                                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                </div>
                                <span class="font-medium text-primary"><?= htmlspecialchars($user['username']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">Admin</span>
                            <?php else: ?>
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($user['status'] === 'active'): ?>
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Suspended</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($user['created_at'])) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Toggle Status -->
                                <?php if ($user['id'] !== Session::userId()): ?>
                                    <form action="/blog-post/dashboard/users/<?= $user['id'] ?>/toggle-status" method="POST" class="inline">
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-yellow-500 transition-colors" 
                                                title="<?= $user['status'] === 'active' ? 'Suspend user' : 'Activate user' ?>">
                                            <?php if ($user['status'] === 'active'): ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <!-- Edit -->
                                <a href="/blog-post/dashboard/users/<?= $user['id'] ?>/edit" 
                                   class="p-2 text-gray-400 hover:text-blue-600 transition-colors" 
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <!-- Delete -->
                                <?php if ($user['id'] !== Session::userId()): ?>
                                    <form action="/blog-post/dashboard/users/<?= $user['id'] ?>/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
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

