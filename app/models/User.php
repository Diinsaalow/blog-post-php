<?php

require_once BASE_PATH . '/core/Model.php';

/**
 * User Model
 * Handles user data operations
 */
class User extends Model
{
    protected string $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findOneBy('email', $email);
    }

    /**
     * Find user by username
     */
    public function findByUsername(string $username): ?array
    {
        return $this->findOneBy('username', $username);
    }

    /**
     * Create a new user with hashed password
     */
    public function createUser(array $data): int
    {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']);
        
        $data['role'] = $data['role'] ?? 'user';
        $data['status'] = $data['status'] ?? 'active';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create($data);
    }

    /**
     * Verify user password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Get all admins
     */
    public function getAdmins(): array
    {
        return $this->findBy('role', 'admin');
    }

    /**
     * Get all active users
     */
    public function getActiveUsers(): array
    {
        return $this->findBy('status', 'active');
    }

    /**
     * Get user bookmarks
     */
    public function getBookmarks(int $userId): array
    {
        $sql = "SELECT p.* FROM posts p 
                INNER JOIN bookmarks b ON p.id = b.post_id 
                WHERE b.user_id = :user_id 
                ORDER BY b.created_at DESC";
        return $this->query($sql, ['user_id' => $userId]);
    }

    /**
     * Add bookmark
     */
    public function addBookmark(int $userId, int $postId): bool
    {
        $stmt = $this->db->prepare("INSERT IGNORE INTO bookmarks (user_id, post_id, created_at) VALUES (:user_id, :post_id, :created_at)");
        return $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Remove bookmark
     */
    public function removeBookmark(int $userId, int $postId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM bookmarks WHERE user_id = :user_id AND post_id = :post_id");
        return $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
    }

    /**
     * Check if post is bookmarked by user
     */
    public function hasBookmarked(int $userId, int $postId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM bookmarks WHERE user_id = :user_id AND post_id = :post_id");
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        return (int) $stmt->fetch()['count'] > 0;
    }
}

