<?php

/**
 * Dashboard Routes
 * Admin-only routes for the dashboard
 */

// Dashboard Home
$router->get('/dashboard', 'dashboard/DashboardController', 'index', ['Admin']);

// Posts Management
$router->get('/dashboard/posts', 'dashboard/PostController', 'index', ['Admin']);
$router->get('/dashboard/posts/create', 'dashboard/PostController', 'create', ['Admin']);
$router->post('/dashboard/posts', 'dashboard/PostController', 'store', ['Admin']);
$router->get('/dashboard/posts/{id}/edit', 'dashboard/PostController', 'edit', ['Admin']);
$router->post('/dashboard/posts/{id}', 'dashboard/PostController', 'update', ['Admin']);
$router->post('/dashboard/posts/{id}/delete', 'dashboard/PostController', 'destroy', ['Admin']);
$router->post('/dashboard/posts/{id}/toggle-featured', 'dashboard/PostController', 'toggleFeatured', ['Admin']);

// Users Management
$router->get('/dashboard/users', 'dashboard/UserController', 'index', ['Admin']);
$router->get('/dashboard/users/{id}/edit', 'dashboard/UserController', 'edit', ['Admin']);
$router->post('/dashboard/users/{id}', 'dashboard/UserController', 'update', ['Admin']);
$router->post('/dashboard/users/{id}/delete', 'dashboard/UserController', 'destroy', ['Admin']);
$router->post('/dashboard/users/{id}/toggle-status', 'dashboard/UserController', 'toggleStatus', ['Admin']);

// Comments Management
$router->get('/dashboard/comments', 'dashboard/CommentController', 'index', ['Admin']);
$router->post('/dashboard/comments/{id}/delete', 'dashboard/CommentController', 'destroy', ['Admin']);

