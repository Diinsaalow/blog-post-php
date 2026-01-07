<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/models/User.php';

/**
 * User Controller (Dashboard)
 * Handles user management for admins
 */
class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Display all users
     */
    public function index(): void
    {
        $users = $this->userModel->all();

        $this->view('dashboard/users/index', [
            'pageTitle' => 'Manage Users',
            'users' => $users,
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Display edit user form
     */
    public function edit(string $id): void
    {
        $user = $this->userModel->find((int) $id);

        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/dashboard/users');
            return;
        }

        $this->view('dashboard/users/edit', [
            'pageTitle' => 'Edit User',
            'user' => $user,
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Update a user
     */
    public function update(string $id): void
    {
        $user = $this->userModel->find((int) $id);

        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/dashboard/users');
            return;
        }

        $username = $this->getPost('username');
        $email = $this->getPost('email');
        $role = $this->getPost('role');
        $status = $this->getPost('status');

        // Check for duplicate email
        $existingUser = $this->userModel->findByEmail($email);
        if ($existingUser && $existingUser['id'] !== (int) $id) {
            Session::flash('error', 'Email already in use.');
            $this->redirect('/dashboard/users/' . $id . '/edit');
            return;
        }

        // Check for duplicate username
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser && $existingUser['id'] !== (int) $id) {
            Session::flash('error', 'Username already in use.');
            $this->redirect('/dashboard/users/' . $id . '/edit');
            return;
        }

        try {
            $this->userModel->update((int) $id, [
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'User updated successfully!');
            $this->redirect('/dashboard/users');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to update user: ' . $e->getMessage());
            $this->redirect('/dashboard/users/' . $id . '/edit');
        }
    }

    /**
     * Toggle user status (active/suspended)
     */
    public function toggleStatus(string $id): void
    {
        $user = $this->userModel->find((int) $id);

        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/dashboard/users');
            return;
        }

        // Prevent self-suspension
        if ((int) $id === Session::userId()) {
            Session::flash('error', 'You cannot suspend yourself.');
            $this->redirect('/dashboard/users');
            return;
        }

        $newStatus = $user['status'] === 'active' ? 'suspended' : 'active';
        
        $this->userModel->update((int) $id, [
            'status' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Session::flash('success', 'User status updated to ' . $newStatus . '!');
        $this->redirect('/dashboard/users');
    }

    /**
     * Delete a user
     */
    public function destroy(string $id): void
    {
        $user = $this->userModel->find((int) $id);

        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/dashboard/users');
            return;
        }

        // Prevent self-deletion
        if ((int) $id === Session::userId()) {
            Session::flash('error', 'You cannot delete yourself.');
            $this->redirect('/dashboard/users');
            return;
        }

        try {
            $this->userModel->delete((int) $id);
            Session::flash('success', 'User deleted successfully!');
        } catch (Exception $e) {
            Session::flash('error', 'Failed to delete user: ' . $e->getMessage());
        }

        $this->redirect('/dashboard/users');
    }
}

