<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/models/Comment.php';
require_once BASE_PATH . '/app/models/Post.php';

/**
 * Comment Controller (Website)
 * Handles comment creation for logged-in users
 */
class CommentController extends Controller
{
    private Comment $commentModel;
    private Post $postModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
        $this->postModel = new Post();
    }

    /**
     * Store a new comment
     */
    public function store(string $postId): void
    {
        // Verify post exists
        $post = $this->postModel->find((int) $postId);
        
        if (!$post) {
            Session::flash('error', 'Post not found.');
            $this->redirect('/posts');
            return;
        }

        $content = $this->getPost('content');

        // Validation
        if (!$content || strlen($content) < 1 || strlen($content) > 1000) {
            Session::flash('error', 'Comment must be between 1 and 1000 characters.');
            $this->redirect('/posts/' . $post['slug']);
            return;
        }

        try {
            $this->commentModel->createComment([
                'post_id' => (int) $postId,
                'author_id' => Session::userId(),
                'content' => $content,
            ]);

            Session::flash('success', 'Comment added successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to add comment. Please try again.');
        }

        $this->redirect('/posts/' . $post['slug']);
    }

    /**
     * Update a comment (owner only)
     */
    public function update(string $id): void
    {
        $comment = $this->commentModel->find((int) $id);

        if (!$comment) {
            Session::flash('error', 'Comment not found.');
            $this->redirect('/posts');
            return;
        }

        // Get post early so we can always redirect back to it
        $post = $this->postModel->find((int) $comment['post_id']);
        $postSlug = $post['slug'] ?? '';
        $redirectUrl = $postSlug ? '/posts/' . $postSlug : '/posts';

        // Check ownership (or admin)
        if (
            !$this->commentModel->isOwner((int) $id, Session::userId()) &&
            !Session::isAdmin()
        ) {
            Session::flash('error', 'You can only edit your own comments.');
            $this->redirect($redirectUrl);
            return;
        }

        $content = $this->getPost('content');

        if (!$content || strlen($content) < 1 || strlen($content) > 1000) {
            Session::flash('error', 'Comment must be between 1 and 1000 characters.');
            $this->redirect($redirectUrl);
            return;
        }

        try {
            $this->commentModel->update((int) $id, [
                'content' => $content,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'Comment updated successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to update comment.');
        }

        $this->redirect($redirectUrl);
    }

    /**
     * Delete a comment (owner only)
     */
    public function destroy(string $id): void
    {
        $comment = $this->commentModel->find((int) $id);

        if (!$comment) {
            Session::flash('error', 'Comment not found.');
            $this->redirect('/');
            return;
        }

        // Check ownership (or admin)
        if (!$this->commentModel->isOwner((int) $id, Session::userId()) && !Session::isAdmin()) {
            Session::flash('error', 'You can only delete your own comments.');
            $this->redirect('/');
            return;
        }

        // Get post before deleting for redirect
        $post = $this->postModel->find($comment['post_id']);

        try {
            $this->commentModel->delete((int) $id);
            Session::flash('success', 'Comment deleted successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to delete comment.');
        }

        $this->redirect('/posts/' . ($post['slug'] ?? ''));
    }
}

