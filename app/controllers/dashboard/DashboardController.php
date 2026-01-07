<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/Post.php';
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/Comment.php';

/**
 * Dashboard Controller
 * Handles the admin dashboard overview
 */
class DashboardController extends Controller
{
    private Post $postModel;
    private User $userModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    /**
     * Display dashboard overview
     */
    public function index(): void
    {
        $totalPosts = $this->postModel->count();
        $totalUsers = $this->userModel->count();
        $totalComments = $this->commentModel->count();
        $recentPosts = $this->postModel->getRecent(5);
        $recentComments = $this->commentModel->getRecent(5);

        $this->view('dashboard/home/index', [
            'pageTitle' => 'Dashboard',
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'totalComments' => $totalComments,
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments,
        ]);
    }
}

