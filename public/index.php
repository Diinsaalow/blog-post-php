<?php

/**
 * Blog Post Application
 * Entry Point
 */

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load core files
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/core/Router.php';

// Start session using Session class (ensures consistency)
Session::start();

// Initialize router
$router = new Router();

// Load routes
require_once BASE_PATH . '/routes/web.php';
require_once BASE_PATH . '/routes/dashboard.php';

// Dispatch the request
try {
    $router->dispatch();
} catch (Exception $e) {
    // Log error in production
    if (true) { // Change to false in production
        echo '<h1>Error</h1>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        echo '<h1>500 - Internal Server Error</h1>';
    }
}

