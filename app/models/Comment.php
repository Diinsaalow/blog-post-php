<?php

require_once BASE_PATH . '/core/Model.php';

/**
 * Comment Model
 * Handles comment data operations
 */
class Comment extends Model
{
    protected string $table = 'comments';

    /**
     * Get comments for a post
     */
    public function getByPost(int $postId): array
    {
        $sql = "SELECT c.*, u.username as author_name, u.avatar_url 
                FROM comments c 
                LEFT JOIN users u ON c.author_id = u.id 
                WHERE c.post_id = :post_id 
                ORDER BY c.created_at DESC";
        return $this->query($sql, ['post_id' => $postId]);
    }

    /**
     * Get comments by user
     */
    public function getByUser(int $userId): array
    {
        $sql = "SELECT c.*, p.title as post_title, p.slug as post_slug 
                FROM comments c 
                LEFT JOIN posts p ON c.post_id = p.id 
                WHERE c.author_id = :author_id 
                ORDER BY c.created_at DESC";
        return $this->query($sql, ['author_id' => $userId]);
    }

    /**
     * Create a new comment
     */
    public function createComment(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create($data);
    }

    /**
     * Check if user owns the comment
     */
    public function isOwner(int $commentId, int $userId): bool
    {
        $comment = $this->find($commentId);
        return $comment && $comment['author_id'] === $userId;
    }

    /**
     * Count comments for a post
     */
    public function countByPost(int $postId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM comments WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $postId]);
        return (int) $stmt->fetch()['count'];
    }

    /**
     * Get all comments for admin
     */
    public function getAllForAdmin(): array
    {
        $sql = "SELECT c.*, u.username as author_name, p.title as post_title 
                FROM comments c 
                LEFT JOIN users u ON c.author_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Get recent comments
     */
    public function getRecent(int $limit = 5): array
    {
        $sql = "SELECT c.*, u.username as author_name, p.title as post_title, p.slug as post_slug 
                FROM comments c 
                LEFT JOIN users u ON c.author_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}

