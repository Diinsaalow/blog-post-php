-- Blog Post Application Database Schema
-- Run this SQL file in phpMyAdmin to create the database and tables

-- Create database
CREATE DATABASE IF NOT EXISTS blog_post_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blog_post_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    avatar_url VARCHAR(500) NULL,
    status ENUM('active', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(200) NOT NULL UNIQUE,
    title VARCHAR(160) NOT NULL,
    excerpt VARCHAR(300) NULL,
    content TEXT NOT NULL,
    cover_image_url VARCHAR(500) NULL,
    author_id INT NOT NULL,
    category VARCHAR(50) DEFAULT 'General',
    is_featured TINYINT(1) DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    views INT DEFAULT 0,
    reading_time_min INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_is_featured (is_featured),
    INDEX idx_is_published (is_published),
    INDEX idx_category (category),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    author_id INT NOT NULL,
    content VARCHAR(1000) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_post_id (post_id),
    INDEX idx_author_id (author_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bookmarks table (for user bookmarks)
CREATE TABLE IF NOT EXISTS bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bookmark (user_id, post_id),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123)
INSERT INTO users (email, username, password_hash, role, status) VALUES 
('admin@blogpost.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active');

-- Insert sample posts
INSERT INTO posts (slug, title, excerpt, content, author_id, category, is_featured, is_published, reading_time_min) VALUES
('welcome-to-blog-post', 'Welcome to Blog Post Application', 'This is your first blog post. Start sharing your ideas with the world!', 'Welcome to the Blog Post Application!\n\nThis is a modern blogging platform built with vanilla PHP and Tailwind CSS. Here you can:\n\n- Create and manage blog posts\n- Allow users to comment on your posts\n- Feature your best content\n- Organize posts by categories\n\nStart creating amazing content today!', 1, 'General', 1, 1, 2),
('getting-started-with-blogging', 'Getting Started with Blogging', 'Learn the basics of creating engaging blog content that resonates with your audience.', 'Blogging is a powerful way to share your knowledge and connect with people around the world.\n\nHere are some tips to get started:\n\n1. Choose topics you are passionate about\n2. Write consistently\n3. Engage with your readers\n4. Use images and media\n5. Optimize for search engines\n\nHappy blogging!', 1, 'Lifestyle', 1, 1, 3),
('technology-trends-2024', 'Technology Trends to Watch', 'Explore the latest technology trends that are shaping our digital future.', 'Technology continues to evolve at a rapid pace. Here are some trends to watch:\n\n- Artificial Intelligence and Machine Learning\n- Web3 and Blockchain\n- Extended Reality (XR)\n- Edge Computing\n- Sustainable Technology\n\nStay informed and embrace the future of technology!', 1, 'Technology', 1, 1, 4);

SELECT 'Database setup completed successfully!' as message;

