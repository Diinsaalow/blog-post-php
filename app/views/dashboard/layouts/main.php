<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?> | Admin Dashboard</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Source Sans Pro', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#1a1a2e',
                        'secondary': '#16213e',
                        'accent': '#e94560',
                        'light': '#f5f5f5',
                        'sidebar': '#0f0f1a',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/blog-post/public/css/dashboard.css">
</head>
<body class="bg-light font-body">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php require_once BASE_PATH . '/app/views/dashboard/partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <?php require_once BASE_PATH . '/app/views/dashboard/partials/header.php'; ?>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                <?= $content ?? '' ?>
            </main>
        </div>
    </div>
    
    <!-- Custom Scripts -->
    <script src="/blog-post/public/js/dashboard.js"></script>
</body>
</html>

