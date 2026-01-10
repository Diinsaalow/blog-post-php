<section class="relative overflow-hidden bg-gradient-to-br from-gray-100/40 to-white pt-24 pb-16 md:pt-32 md:pb-24">
    <!-- Background decorations -->
    <div class="absolute inset-0 z-0 opacity-50">
        <div class="absolute -right-20 -top-20 h-[400px] w-[400px] rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-20 h-[300px] w-[200px] rounded-full bg-blue-500/10 blur-3xl"></div>
    </div>

    <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h1 class="max-w-4xl text-4xl font-bold tracking-tight md:text-6xl lg:text-7xl animate-fade-in">
                Insights &amp; Ideas for <br /> the 
                <span class="text-blue-600">Modern</span> Web
            </h1>
            
            <p class="mt-6 max-w-2xl text-lg text-gray-500 animate-fade-in animation-delay-100">
                Discover thought-provoking stories, in-depth analyses, and expert
                opinions on web development, design, and technology.
            </p>
            
            <div class="mt-10 flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0 animate-fade-in animation-delay-200">
                <a href="<?= url('/posts') ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25">
                    Explore All Articles
                    <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom gradient fade -->
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent"></div>
</section>
