<?php

/**
 * Website Routes
 * Public routes for the user-facing website
 * 
 * NOTE: Static routes MUST come before dynamic routes to avoid conflicts
 */

// Home
$router->get('/', 'website/HomeController', 'index');

// Authentication (static routes)
$router->get('/login', 'website/AuthController', 'loginForm');
$router->post('/login', 'website/AuthController', 'login');
$router->get('/register', 'website/AuthController', 'registerForm');
$router->post('/register', 'website/AuthController', 'register');
$router->get('/logout', 'website/AuthController', 'logout');

// Posts - static routes first
$router->get('/posts', 'website/PostController', 'index');

// Posts - dynamic routes with parameters (order matters!)
$router->get('/posts/category/{category}', 'website/PostController', 'category');
$router->post('/posts/{postId}/comments', 'website/CommentController', 'store', ['Auth']);

// Comments - update/delete from website (authenticated users)
$router->post('/comments/{id}', 'website/CommentController', 'update', ['Auth']);
$router->post('/comments/{id}/delete', 'website/CommentController', 'destroy', ['Auth']);
$router->get('/posts/{slug}', 'website/PostController', 'show');

