<?php

/**
 * Application Configuration
 */
return [
    'name' => 'Blog Post Application',
    'url' => 'http://localhost/blog-post',
    'debug' => true,
    
    // Pagination settings
    'posts_per_page' => 10,
    'featured_posts_count' => 3,
    'recent_posts_count' => 10,
    
    // Upload settings
    'upload_path' => BASE_PATH . '/public/uploads',
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    'max_file_size' => 5 * 1024 * 1024, // 5MB
    
    // Cloudinary settings (optional - for cloud storage)
    'cloudinary' => [
        'cloud_name' => '',
        'api_key' => '',
        'api_secret' => '',
    ],
];

