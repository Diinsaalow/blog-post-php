<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/models/Post.php';

/**
 * Post Controller (Dashboard)
 * Handles post management for admins
 */
class PostController extends Controller
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    /**
     * Display all posts
     */
    public function index(): void
    {
        $posts = $this->postModel->getAllForAdmin();

        $this->view('dashboard/posts/index', [
            'pageTitle' => 'Manage Posts',
            'posts' => $posts,
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Display create post form
     */
    public function create(): void
    {
        $this->view('dashboard/posts/create', [
            'pageTitle' => 'Create Post',
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Store a new post
     */
    public function store(): void
    {
        $title = $this->getPost('title');
        $excerpt = $this->getPost('excerpt');
        $content = $this->getPost('content', false);
        $category = $this->getPost('category');
        $coverImageUrl = $this->getPost('cover_image_url');
        $readingTimeMin = (int) $this->getPost('reading_time_min');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $isPublished = isset($_POST['is_published']) ? 1 : 0;

        // Validation
        if (!$title || strlen($title) < 1 || strlen($title) > 160) {
            Session::flash('error', 'Title is required and must be 1-160 characters.');
            $this->redirect('/dashboard/posts/create');
            return;
        }

        if ($excerpt && strlen($excerpt) > 300) {
            Session::flash('error', 'Excerpt must be 300 characters or less.');
            $this->redirect('/dashboard/posts/create');
            return;
        }

        try {
            $this->postModel->createPost([
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => $content,
                'category' => $category,
                'cover_image_url' => $coverImageUrl,
                'reading_time_min' => $readingTimeMin ?: 5,
                'is_featured' => $isFeatured,
                'is_published' => $isPublished,
                'author_id' => Session::userId(),
            ]);

            Session::flash('success', 'Post created successfully!');
            $this->redirect('/dashboard/posts');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to create post: ' . $e->getMessage());
            $this->redirect('/dashboard/posts/create');
        }
    }

    /**
     * Display edit post form
     */
    public function edit(string $id): void
    {
        $post = $this->postModel->find((int) $id);

        if (!$post) {
            Session::flash('error', 'Post not found.');
            $this->redirect('/dashboard/posts');
            return;
        }

        $this->view('dashboard/posts/edit', [
            'pageTitle' => 'Edit Post',
            'post' => $post,
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Update a post
     */
    public function update(string $id): void
    {
        $post = $this->postModel->find((int) $id);

        if (!$post) {
            Session::flash('error', 'Post not found.');
            $this->redirect('/dashboard/posts');
            return;
        }

        $title = $this->getPost('title');
        $excerpt = $this->getPost('excerpt');
        $content = $this->getPost('content', false);
        $category = $this->getPost('category');
        $coverImageUrl = $this->getPost('cover_image_url');
        $readingTimeMin = (int) $this->getPost('reading_time_min');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $isPublished = isset($_POST['is_published']) ? 1 : 0;

        try {
            $this->postModel->update((int) $id, [
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => $content,
                'category' => $category,
                'cover_image_url' => $coverImageUrl,
                'reading_time_min' => $readingTimeMin ?: 5,
                'is_featured' => $isFeatured,
                'is_published' => $isPublished,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'Post updated successfully!');
            $this->redirect('/dashboard/posts');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to update post: ' . $e->getMessage());
            $this->redirect('/dashboard/posts/' . $id . '/edit');
        }
    }

    /**
     * Delete a post
     */
    public function destroy(string $id): void
    {
        $post = $this->postModel->find((int) $id);

        if (!$post) {
            Session::flash('error', 'Post not found.');
            $this->redirect('/dashboard/posts');
            return;
        }

        try {
            $this->postModel->delete((int) $id);
            Session::flash('success', 'Post deleted successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to delete post: ' . $e->getMessage());
        }

        $this->redirect('/dashboard/posts');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(string $id): void
    {
        $post = $this->postModel->find((int) $id);

        if (!$post) {
            Session::flash('error', 'Post not found.');
            $this->redirect('/dashboard/posts');
            return;
        }

        $this->postModel->update((int) $id, [
            'is_featured' => $post['is_featured'] ? 0 : 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Session::flash('success', 'Post featured status updated!');
        $this->redirect('/dashboard/posts');
    }
}

