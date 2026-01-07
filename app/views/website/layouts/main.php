<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Blog Post') ?> | Blog Post Application</title>
    
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
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/blog-post/public/css/style.css">
</head>
<body class="bg-light font-body min-h-screen flex flex-col">
    
    <?php require_once BASE_PATH . '/app/views/website/partials/header.php'; ?>
    
    <main class="flex-grow">
        <?= $content ?? '' ?>
    </main>
    
    <?php require_once BASE_PATH . '/app/views/website/partials/footer.php'; ?>
    
    <!-- Custom Scripts -->
    <script src="/blog-post/public/js/app.js"></script>
</body>
</html>

