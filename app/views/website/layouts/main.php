<?php
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/helpers/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Bloggies') ?> | Bloggies</title>
    
    <!-- Google Fonts - Inter & Merriweather -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'serif': ['Merriweather', 'Georgia', 'serif'],
                    },
                    colors: {
                        'primary': {
                            DEFAULT: 'oklch(0.623 0.214 259.815)',
                            foreground: 'oklch(0.97 0.014 254.604)',
                        },
                        'background': 'oklch(1 0 0)',
                        'foreground': 'oklch(0.141 0.005 285.823)',
                        'card': {
                            DEFAULT: 'oklch(1 0 0)',
                            foreground: 'oklch(0.141 0.005 285.823)',
                        },
                        'muted': {
                            DEFAULT: 'oklch(0.967 0.001 286.375)',
                            foreground: 'oklch(0.552 0.016 285.938)',
                        },
                        'accent': {
                            DEFAULT: 'oklch(0.967 0.001 286.375)',
                            foreground: 'oklch(0.21 0.006 285.885)',
                        },
                        'destructive': 'oklch(0.577 0.245 27.325)',
                        'border': 'oklch(0.92 0.004 286.32)',
                        'ring': 'oklch(0.623 0.214 259.815)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        :root {
            --radius: 0.5rem;
            --primary: oklch(0.623 0.214 259.815);
            --primary-foreground: oklch(0.97 0.014 254.604);
            --background: oklch(1 0 0);
            --foreground: oklch(0.141 0.005 285.823);
            --muted: oklch(0.967 0.001 286.375);
            --muted-foreground: oklch(0.552 0.016 285.938);
            --border: oklch(0.92 0.004 286.32);
            --ring: oklch(0.623 0.214 259.815);
            --destructive: oklch(0.577 0.245 27.325);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transform: translateY(-4px);
        }
        
        .animation-delay-100 { animation-delay: 100ms; }
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-300 { animation-delay: 300ms; }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        
        .tag {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            border: 1px solid var(--border);
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        /* Toast notifications */
        .toast {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }
        
        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Prose styles for blog content */
        .prose { max-width: 65ch; }
        .prose p { margin-bottom: 1.25em; line-height: 1.75; }
        .prose h2 { font-size: 1.5em; font-weight: 700; margin: 2em 0 1em; }
        .prose h3 { font-size: 1.25em; font-weight: 600; margin: 1.5em 0 0.75em; }
        .prose ul, .prose ol { margin: 1em 0; padding-left: 1.5em; }
        .prose li { margin: 0.5em 0; }
        .prose a { color: var(--primary); text-decoration: underline; }
        .prose img { border-radius: 0.5rem; margin: 2em 0; }
        .prose blockquote { 
            border-left: 4px solid var(--primary);
            padding-left: 1em;
            font-style: italic;
            color: var(--muted-foreground);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">
    
    <?php require_once BASE_PATH . '/app/views/website/partials/header.php'; ?>
    
    <!-- Flash Messages -->
    <?php if ($success = Session::getFlash('success')): ?>
        <div class="toast bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2" id="toast">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span><?= e($success) ?></span>
        </div>
    <?php endif; ?>
    
    <?php if ($error = Session::getFlash('error')): ?>
        <div class="toast bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2" id="toast">
            <i data-lucide="x-circle" class="w-5 h-5"></i>
            <span><?= e($error) ?></span>
        </div>
    <?php endif; ?>
    
    <main class="flex-grow">
        <?= $content ?? '' ?>
    </main>
    
    <?php require_once BASE_PATH . '/app/views/website/partials/footer.php'; ?>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
        
        // Auto-hide toast after 4 seconds
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(-50%) translateY(-100%)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
    
    <!-- Custom Scripts -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
