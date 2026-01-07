<?php

require_once BASE_PATH . '/core/Session.php';

/**
 * Admin Middleware
 * Ensures user is logged in and has admin role
 */
class AdminMiddleware
{
    /**
     * Handle the middleware check
     */
    public function handle(): bool
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Please login to access this page.');
            header('Location: /blog-post/login');
            exit;
        }

        if (!Session::isAdmin()) {
            Session::flash('error', 'You do not have permission to access this page.');
            header('Location: /blog-post/');
            exit;
        }

        return true;
    }
}

