<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<!-- Back Link -->
<div class="mb-6">
    <a href="<?= url('/dashboard/users') ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
        <span>Back to Users</span>
    </a>
</div>

<!-- Form -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 max-w-2xl">
    <form action="<?= url('/dashboard/users/' . $user['id']) ?>" method="POST" class="space-y-6">
        <input type="hidden" name="_method" value="PUT">
        
        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                Username <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required
                value="<?= htmlspecialchars($user['username']) ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
        </div>
        
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required
                value="<?= htmlspecialchars($user['email']) ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
        </div>
        
        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                Role
            </label>
            <select 
                id="role" 
                name="role"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        
        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                Status
            </label>
            <select 
                id="status" 
                name="status"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
                <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="suspended" <?= $user['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
            </select>
        </div>
        
        <!-- Submit -->
        <div class="flex justify-end space-x-4">
            <a href="<?= url('/dashboard/users') ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                Update User
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/dashboard/layouts/main.php';
?>
