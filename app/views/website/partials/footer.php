<footer class="bg-gray-100 py-8 px-4 mt-20">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0">
            <h2 class="text-2xl font-bold text-blue-600">BLOGGIES</h2>
        </div>

        <nav class="flex gap-6">
            <a href="<?= url('/') ?>" class="text-gray-500 hover:text-gray-900 transition-colors">
                Home
            </a>
            <a href="<?= url('/posts') ?>" class="text-gray-500 hover:text-gray-900 transition-colors">
                Blogs
            </a>
        </nav>
    </div>

    <div class="mt-8 text-center text-sm text-gray-500">
        &copy; <?= date('Y') ?> BLOGGIES. All rights reserved.
    </div>
</footer>
