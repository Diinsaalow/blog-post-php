<?php
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/helpers/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?> | BLOGGIES Admin</title>
    
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
                        'sidebar': 'oklch(0.141 0.005 285.823)',
                    },
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php require_once BASE_PATH . '/app/views/dashboard/partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <?php require_once BASE_PATH . '/app/views/dashboard/partials/header.php'; ?>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto bg-gray-50">
                <!-- Flash Messages -->
                <?php if ($success = Session::getFlash('success')): ?>
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2 animate-fade-in">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span><?= e($success) ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($error = Session::getFlash('error')): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-2 animate-fade-in">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                        <span><?= e($error) ?></span>
                    </div>
                <?php endif; ?>
                
                <?= $content ?? '' ?>
            </main>
        </div>
    </div>
    
    <!-- Custom Scripts -->
    <script src="<?= asset('js/dashboard.js') ?>"></script>
</body>
</html>
