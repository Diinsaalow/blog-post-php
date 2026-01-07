<?php

/**
 * Base Controller Class
 * All controllers extend this class
 */
class Controller
{
    /**
     * Render a view file with optional data
     */
    protected function view(string $view, array $data = []): void
    {
        // Extract data to make variables available in view
        extract($data);
        
        // Build the view path
        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new Exception("View '{$view}' not found.");
        }
        
        require_once $viewPath;
    }

    /**
     * Redirect to a URL (automatically prepends base path)
     */
    protected function redirect(string $url): void
    {
        $basePath = '/blog-post';
        
        // If URL doesn't start with http or the base path, prepend base path
        if (!preg_match('/^https?:\/\//', $url) && strpos($url, $basePath) !== 0) {
            $url = $basePath . $url;
        }
        
        // Ensure session data is saved before redirect
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        
        header("Location: {$url}");
        exit;
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Get POST data with optional sanitization
     */
    protected function getPost(string $key, bool $sanitize = true): mixed
    {
        $value = $_POST[$key] ?? null;
        
        if ($sanitize && $value !== null) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        
        return $value;
    }

    /**
     * Get GET data with optional sanitization
     */
    protected function getQuery(string $key, bool $sanitize = true): mixed
    {
        $value = $_GET[$key] ?? null;
        
        if ($sanitize && $value !== null) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        
        return $value;
    }
}

