<?php

/**
 * Database Class
 * Handles PDO database connection using singleton pattern
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Get the database connection instance
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require_once BASE_PATH . '/config/database.php';
            
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            
            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}
}

