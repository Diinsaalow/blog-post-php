<?php

require_once BASE_PATH . '/core/Session.php';

/**
 * Auth Middleware
 * Ensures user is logged in
 */
class AuthMiddleware
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

        // Check if user is suspended
        if (Session::get('user_status') === 'suspended') {
            Session::destroy();
            Session::flash('error', 'Your account has been suspended.');
            header('Location: /blog-post/login');
            exit;
        }

        return true;
    }
}

