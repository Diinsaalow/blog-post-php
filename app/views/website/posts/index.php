<?php
require_once BASE_PATH . '/app/helpers/functions.php';
require_once BASE_PATH . '/core/Session.php';

$isAdmin = Session::isAdmin();

ob_start();
?>

<div class="min-h-screen bg-white">
    <main class="pt-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-12">
        <!-- Header with Search -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <h1 class="text-3xl font-bold">All Blog Posts</h1>

            <div class="flex items-center space-x-4 w-full md:w-auto">
                <!-- Search Form -->
                <form action="<?= url('/posts') ?>" method="GET" class="relative flex-1 md:flex-none">
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="search" 
                           name="search" 
                           placeholder="Search blogs..." 
                           value="<?= e($search ?? '') ?>"
                           class="pl-10 pr-4 py-2 w-full md:w-[300px] border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </form>
            </div>
        </div>

        <!-- Search Results Info -->
        <?php if (!empty($search)): ?>
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-blue-800">
                    Showing results for: <strong><?= e($search) ?></strong>
                    <a href="<?= url('/posts') ?>" class="ml-2 text-blue-600 hover:underline">Clear search</a>
                </p>
            </div>
        <?php endif; ?>

        <!-- Blog Grid -->
        <?php if (empty($posts)): ?>
            <div class="text-center py-12">
                <i data-lucide="file-text" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h2 class="text-xl font-semibold mb-2">No blogs found</h2>
                <p class="text-gray-500 mb-6">
                    <?= !empty($search) ? 'Try changing your search query' : 'Check back soon for new content!' ?>
                </p>
                <?php if (!empty($search)): ?>
                    <a href="<?= url('/posts') ?>" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        View All Posts
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="posts-grid">
                <?php foreach ($posts as $index => $post): ?>
                    <div class="opacity-0 translate-y-4 animate-fade-in <?= 'animation-delay-' . (($index % 3 + 1) * 100) ?>">
                        <!-- Blog Card -->
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white card-hover flex flex-col h-full group">
                            <div class="overflow-hidden relative h-48">
                                <img src="<?= e($post['cover_image_url'] ?? 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?auto=format&fit=crop&q=80') ?>" 
                                     alt="<?= e($post['title']) ?>"
                                     class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>

                            <div class="flex flex-col p-6 flex-1">
                                <?php if (!empty($post['category'])): ?>
                                    <span class="tag text-gray-700 mb-3 self-start">
                                        <?= e($post['category']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <h3 class="text-xl font-bold mb-2 transition-colors group-hover:text-blue-600">
                                    <a href="<?= url('/posts/' . e($post['slug'])) ?>">
                                        <?= e($post['title']) ?>
                                    </a>
                                </h3>

                                <p class="text-gray-500 mb-4 line-clamp-2 flex-grow">
                                    <?= e(truncate(strip_tags($post['excerpt'] ?? $post['content']), 100)) ?>
                                </p>

                                <div class="mt-auto">
                                    <div class="flex items-center text-sm text-gray-500 space-x-4 mb-4">
                                        <div class="flex items-center">
                                            <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                                            <span><?= e($post['author_name'] ?? 'Unknown') ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i data-lucide="calendar-days" class="w-4 h-4 mr-1"></i>
                                            <span><?= formatDate($post['created_at']) ?></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <a href="<?= url('/posts/' . e($post['slug'])) ?>" 
                                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                            Read More →
                                        </a>

                                        <?php if ($isAdmin): ?>
                                            <div class="flex items-center space-x-2">
                                                <a href="<?= url('/dashboard/posts/' . $post['id'] . '/edit') ?>" 
                                                   class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors"
                                                   title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                <form action="<?= url('/dashboard/posts/' . $post['id'] . '/delete') ?>" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                                    <button type="submit" 
                                                            class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors"
                                                            title="Delete">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="flex justify-center items-center space-x-2 mt-12">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= url('/posts?page=' . ($currentPage - 1) . (!empty($search) ? '&search=' . urlencode($search) : '')) ?>" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                            Previous
                        </a>
                    <?php endif; ?>
                    
                    <span class="text-sm text-gray-500">
                        Page <?= $currentPage ?> of <?= $totalPages ?>
                    </span>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= url('/posts?page=' . ($currentPage + 1) . (!empty($search) ? '&search=' . urlencode($search) : '')) ?>" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                            <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>
