<?php
require_once BASE_PATH . '/app/helpers/functions.php';
require_once BASE_PATH . '/core/Session.php';
ob_start();
?>

<!-- Header -->
<div class="mb-6">
    <p class="text-gray-500">Manage all registered users</p>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if (empty($users)): ?>
        <div class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
            <p class="text-gray-500">No users found.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
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
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                    </div>
                                    <span class="font-medium text-gray-900"><?= htmlspecialchars($user['username']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Admin</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">User</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Suspended</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500"><?= formatDate($user['created_at']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Toggle Status -->
                                    <?php if ($user['id'] !== Session::userId()): ?>
                                        <form action="<?= url('/dashboard/users/' . $user['id'] . '/toggle-status') ?>" method="POST" class="inline">
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-yellow-500 transition-colors" 
                                                    title="<?= $user['status'] === 'active' ? 'Suspend user' : 'Activate user' ?>">
                                                <?php if ($user['status'] === 'active'): ?>
                                                    <i data-lucide="ban" class="w-5 h-5"></i>
                                                <?php else: ?>
                                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <!-- Edit -->
                                    <a href="<?= url('/dashboard/users/' . $user['id'] . '/edit') ?>" 
                                       class="p-2 text-gray-400 hover:text-blue-600 transition-colors" 
                                       title="Edit">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                    
                                    <!-- Delete -->
                                    <?php if ($user['id'] !== Session::userId()): ?>
                                        <form action="<?= url('/dashboard/users/' . $user['id'] . '/delete') ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
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
