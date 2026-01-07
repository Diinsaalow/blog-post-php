<?php
/**
 * Posts Index View
 * Displays all posts with pagination and search
 */

ob_start();
?>

<section class="py-16 bg-light min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="font-display text-4xl font-bold text-primary mb-4">All Posts</h1>
            <p class="text-gray-600">Browse through our collection of articles</p>
        </div>
        
        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mb-12">
            <form action="/blog-post/posts" method="GET" class="flex">
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($search ?? '') ?>"
                    placeholder="Search posts..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                >
                <button type="submit" class="bg-accent hover:bg-red-600 text-white px-6 py-3 rounded-r-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>
        
        <?php if (!empty($search)): ?>
            <div class="text-center mb-8">
                <p class="text-gray-600">
                    Search results for: <strong class="text-primary">"<?= htmlspecialchars($search) ?>"</strong>
                    <a href="/blog-post/posts" class="text-accent hover:underline ml-2">Clear</a>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Posts Grid -->
        <?php if (empty($posts)): ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-lg">No posts found.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="<?= htmlspecialchars($post['cover_image_url'] ?? '/blog-post/public/images/placeholder.jpg') ?>" 
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute top-3 left-3">
                                <span class="bg-primary/90 text-white text-xs px-3 py-1 rounded-full">
                                    <?= htmlspecialchars($post['category'] ?? 'General') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h2 class="font-display text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors line-clamp-2">
                                <a href="/blog-post/posts/<?= htmlspecialchars($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                <?= htmlspecialchars($post['excerpt'] ?? '') ?>
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></span>
                                <span><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-12 space-x-2">
                    <?php if ($currentPage > 1): ?>
                        <a href="/blog-post/posts?page=<?= $currentPage - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="/blog-post/posts?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                           class="px-4 py-2 rounded-lg transition-colors <?= $i === $currentPage ? 'bg-accent text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/blog-post/posts?page=<?= $currentPage + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Next
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>

