<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/Post.php';

/**
 * Home Controller
 * Handles the main website homepage
 */
class HomeController extends Controller
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    /**
     * Display the homepage with hero, featured posts, and recent posts
     */
    public function index(): void
    {
        $featuredPosts = $this->postModel->getFeatured(3);
        $recentPosts = $this->postModel->getRecent(10);

        $this->view('website/home/index', [
            'pageTitle' => 'Home',
            'featuredPosts' => $featuredPosts,
            'recentPosts' => $recentPosts,
        ]);
    }
}

