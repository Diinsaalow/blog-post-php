<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/models/Comment.php';

/**
 * Comment Controller (Dashboard)
 * Handles comment management for admins
 */
class CommentController extends Controller
{
    private Comment $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    /**
     * Display all comments
     */
    public function index(): void
    {
        $comments = $this->commentModel->getAllForAdmin();

        $this->view('dashboard/comments/index', [
            'pageTitle' => 'Manage Comments',
            'comments' => $comments,
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Delete a comment
     */
    public function destroy(string $id): void
    {
        $comment = $this->commentModel->find((int) $id);

        if (!$comment) {
            Session::flash('error', 'Comment not found.');
            $this->redirect('/dashboard/comments');
            return;
        }

        try {
            $this->commentModel->delete((int) $id);
            Session::flash('success', 'Comment deleted successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to delete comment: ' . $e->getMessage());
        }

        $this->redirect('/dashboard/comments');
    }
}

