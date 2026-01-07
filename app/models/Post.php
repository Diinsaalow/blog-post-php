<?php

require_once BASE_PATH . '/core/Model.php';

/**
 * Post Model
 * Handles blog post data operations
 */
class Post extends Model
{
    protected string $table = 'posts';

    /**
     * Get all published posts with pagination
     */
    public function getPublished(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.is_published = 1 
                ORDER BY p.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Count published posts
     */
    public function countPublished(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM posts WHERE is_published = 1");
        return (int) $stmt->fetch()['count'];
    }

    /**
     * Get featured posts
     */
    public function getFeatured(int $limit = 3): array
    {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.is_featured = 1 AND p.is_published = 1 
                ORDER BY p.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Get recent posts
     */
    public function getRecent(int $limit = 10): array
    {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.is_published = 1 
                ORDER BY p.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Find post by slug
     */
    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.slug = :slug";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        
        return $result ?: null;
    }

    /**
     * Increment view count
     */
    public function incrementViews(int $postId): bool
    {
        $stmt = $this->db->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
        return $stmt->execute(['id' => $postId]);
    }

    /**
     * Search posts by title, excerpt, or content
     */
    public function search(string $query, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $searchTerm = '%' . $query . '%';
        
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.is_published = 1 
                AND (p.title LIKE :query1 OR p.excerpt LIKE :query2 OR p.content LIKE :query3)
                ORDER BY p.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':query1', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':query2', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':query3', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Get posts by category
     */
    public function getByCategory(string $category, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                WHERE p.is_published = 1 AND p.category = :category
                ORDER BY p.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Generate unique slug from title
     */
    public function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->findOneBy('slug', $slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Create a new post
     */
    public function createPost(array $data): int
    {
        $data['slug'] = $this->generateSlug($data['title']);
        $data['is_featured'] = $data['is_featured'] ?? 0;
        $data['is_published'] = $data['is_published'] ?? 1;
        $data['views'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create($data);
    }

    /**
     * Get all posts for admin
     */
    public function getAllForAdmin(): array
    {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                ORDER BY p.created_at DESC";
        return $this->query($sql);
    }
}

