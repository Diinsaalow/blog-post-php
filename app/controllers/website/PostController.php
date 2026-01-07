<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/app/models/Post.php';
require_once BASE_PATH . '/app/models/Comment.php';

/**
 * Post Controller (Website)
 * Handles post viewing for public users
 */
class PostController extends Controller
{
    private Post $postModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->commentModel = new Comment();
    }

    /**
     * Display all posts with pagination
     */
    public function index(): void
    {
        $page = (int) ($this->getQuery('page') ?? 1);
        $search = $this->getQuery('search') ?? '';

        if ($search) {
            $posts = $this->postModel->search($search, $page);
        } else {
            $posts = $this->postModel->getPublished($page);
        }

        $totalPosts = $this->postModel->countPublished();
        $totalPages = ceil($totalPosts / 10);

        $this->view('website/posts/index', [
            'pageTitle' => 'All Posts',
            'posts' => $posts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
        ]);
    }

    /**
     * Display a single post by slug
     */
    public function show(string $slug): void
    {
        $post = $this->postModel->findBySlug($slug);

        if (!$post || !$post['is_published']) {
            http_response_code(404);
            $this->view('errors/404', ['pageTitle' => 'Post Not Found']);
            return;
        }

        // Increment view count
        $this->postModel->incrementViews($post['id']);

        // Get comments for the post
        $comments = $this->commentModel->getByPost($post['id']);
        $commentCount = $this->commentModel->countByPost($post['id']);

        $this->view('website/posts/show', [
            'pageTitle' => $post['title'],
            'post' => $post,
            'comments' => $comments,
            'commentCount' => $commentCount,
        ]);
    }

    /**
     * Display posts by category
     */
    public function category(string $category): void
    {
        $page = (int) ($this->getQuery('page') ?? 1);
        $posts = $this->postModel->getByCategory($category, $page);

        $this->view('website/posts/category', [
            'pageTitle' => ucfirst($category) . ' Posts',
            'posts' => $posts,
            'category' => $category,
            'currentPage' => $page,
        ]);
    }
}

