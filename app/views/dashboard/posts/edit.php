<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<!-- Back Link -->
<div class="mb-6">
    <a href="<?= url('/dashboard/posts') ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
        <span>Back to Posts</span>
    </a>
</div>

<!-- Form -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <form action="<?= url('/dashboard/posts/' . $post['id']) ?>" method="POST" class="space-y-6">
        <input type="hidden" name="_method" value="PUT">
        
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Title <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required
                maxlength="160"
                value="<?= htmlspecialchars($post['title']) ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
        </div>
        
        <!-- Excerpt -->
        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                Excerpt
            </label>
            <textarea 
                id="excerpt" 
                name="excerpt" 
                rows="2"
                maxlength="300"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-colors"
            ><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
        </div>
        
        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                Content <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="content" 
                name="content" 
                rows="12"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-colors font-serif"
            ><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
        </div>
        
        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category
                </label>
                <select 
                    id="category" 
                    name="category"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                >
                    <?php $categories = ['General', 'Technology', 'Lifestyle', 'Travel', 'Food', 'Health', 'Business']; ?>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($post['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Reading Time -->
            <div>
                <label for="reading_time_min" class="block text-sm font-medium text-gray-700 mb-2">
                    Reading Time (minutes)
                </label>
                <input 
                    type="number" 
                    id="reading_time_min" 
                    name="reading_time_min" 
                    min="1"
                    max="60"
                    value="<?= $post['reading_time_min'] ?? 5 ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                >
            </div>
        </div>
        
        <!-- Cover Image URL -->
        <div>
            <label for="cover_image_url" class="block text-sm font-medium text-gray-700 mb-2">
                Cover Image URL
            </label>
            <input 
                type="url" 
                id="cover_image_url" 
                name="cover_image_url"
                value="<?= htmlspecialchars($post['cover_image_url'] ?? '') ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
            <?php if (!empty($post['cover_image_url'])): ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars($post['cover_image_url']) ?>" alt="Current cover" class="w-32 h-20 object-cover rounded border border-gray-200">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Checkboxes -->
        <div class="flex items-center space-x-6">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" <?= $post['is_published'] ? 'checked' : '' ?> class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                <span class="text-sm text-gray-700">Published</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?> class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                <span class="text-sm text-gray-700">Featured</span>
            </label>
        </div>
        
        <!-- Submit -->
        <div class="flex justify-end space-x-4">
            <a href="<?= url('/dashboard/posts') ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                Update Post
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/dashboard/layouts/main.php';
?>
