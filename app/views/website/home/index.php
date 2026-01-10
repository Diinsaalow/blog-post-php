<?php
require_once BASE_PATH . '/app/helpers/functions.php';
ob_start();
?>

<!-- Hero Section -->
<?php require_once BASE_PATH . '/app/views/website/partials/hero.php'; ?>

<!-- Main Content -->
<section class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <!-- Featured Post Section -->
    <?php if (!empty($featuredPosts)): ?>
        <?php $featured = $featuredPosts[0]; ?>
        <div class="mb-12">
            <h2 class="text-3xl font-bold mb-10">Featured Post</h2>
            
            <!-- Featured Blog Card -->
            <article class="relative h-[500px] md:h-[600px] rounded-lg overflow-hidden group cursor-pointer"
                     onclick="window.location.href='<?= url('/posts/' . e($featured['slug'])) ?>'">
                <!-- Background image with overlay -->
                <div class="absolute inset-0">
                    <img src="<?= e($featured['cover_image_url'] ?? 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?auto=format&fit=crop&q=80') ?>" 
                         alt="<?= e($featured['title']) ?>"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
                </div>

                <!-- Content -->
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                    <?php if (!empty($featured['category'])): ?>
                        <span class="tag bg-white/10 backdrop-blur-sm text-white mb-4">
                            <?= e($featured['category']) ?>
                        </span>
                    <?php endif; ?>

                    <a href="<?= url('/posts/' . e($featured['slug'])) ?>" class="block">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 transition-colors hover:text-blue-400">
                            <?= e($featured['title']) ?>
                        </h2>
                    </a>

                    <p class="text-white/80 mb-6 max-w-2xl line-clamp-3">
                        <?= e($featured['excerpt'] ?? truncate(strip_tags($featured['content']), 150)) ?>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center text-sm text-white/70 space-x-4 mb-4 sm:mb-0">
                            <div class="flex items-center">
                                <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                                <span><?= e($featured['author_name'] ?? 'Unknown') ?></span>
                            </div>
                            <div class="flex items-center">
                                <i data-lucide="calendar-days" class="w-4 h-4 mr-1"></i>
                                <span><?= formatDate($featured['created_at']) ?></span>
                            </div>
                        </div>

                        <a href="<?= url('/posts/' . e($featured['slug'])) ?>" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Read Article
                        </a>
                    </div>
                </div>
            </article>
        </div>
    <?php endif; ?>

    <!-- Recent Posts Section -->
    <?php if (!empty($recentPosts)): ?>
        <div class="mt-20">
            <h2 class="text-3xl font-bold mb-10">Recent Posts</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach (array_slice($recentPosts, 0, 6) as $index => $post): ?>
                    <div class="opacity-0 translate-y-4 animate-fade-in <?= 'animation-delay-' . (($index % 3 + 1) * 100) ?>">
                        <!-- Blog Card -->
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white card-hover flex flex-col h-full">
                            <div class="overflow-hidden relative h-48">
                                <img src="<?= e($post['cover_image_url'] ?? 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?auto=format&fit=crop&q=80') ?>" 
                                     alt="<?= e($post['title']) ?>"
                                     class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>

                            <div class="flex flex-col p-6 flex-1">
                                <?php if (!empty($post['category'])): ?>
                                    <span class="tag text-gray-700 mb-3 self-start">
                                        <?= e($post['category']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <h3 class="text-xl font-bold mb-2 transition-colors hover:text-blue-600">
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

                                    <a href="<?= url('/posts/' . e($post['slug'])) ?>" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                        Read More →
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($recentPosts) > 6): ?>
                <div class="flex justify-center mt-10">
                    <a href="<?= url('/posts') ?>" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 transition-colors">
                        View All Posts
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <h2 class="text-2xl font-bold text-gray-900">No posts yet</h2>
            <p class="text-gray-500 mt-2">Check back soon for new content!</p>
        </div>
    <?php endif; ?>
    
</section>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/app/views/website/layouts/main.php';
?>
