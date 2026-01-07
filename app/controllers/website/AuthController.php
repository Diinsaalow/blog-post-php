<?php

require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/app/models/User.php';

/**
 * Auth Controller (Website)
 * Handles user authentication
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Display login form
     */
    public function loginForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('website/auth/login', [
            'pageTitle' => 'Login',
            'error' => Session::getFlash('error'),
        ]);
    }

    /**
     * Handle login submission
     */
    public function login(): void
    {
        $email = $this->getPost('email');
        $password = $this->getPost('password', false);

        if (!$email || !$password) {
            Session::flash('error', 'Please fill in all fields.');
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password_hash'])) {
            Session::flash('error', 'Invalid email or password.');
            $this->redirect('/login');
            return;
        }

        if ($user['status'] !== 'active') {
            Session::flash('error', 'Your account has been suspended.');
            $this->redirect('/login');
            return;
        }

        // Set session data
        Session::set('user_id', $user['id']);
        Session::set('user_role', $user['role']);
        Session::set('username', $user['username']);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            $this->redirect('/dashboard');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Display registration form
     */
    public function registerForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('website/auth/register', [
            'pageTitle' => 'Register',
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ]);
    }

    /**
     * Handle registration submission
     */
    public function register(): void
    {
        $email = $this->getPost('email');
        $username = $this->getPost('username');
        $password = $this->getPost('password', false);
        $confirmPassword = $this->getPost('confirm_password', false);

        // Validation
        if (!$email || !$username || !$password || !$confirmPassword) {
            Session::flash('error', 'Please fill in all fields.');
            $this->redirect('/register');
            return;
        }

        if ($password !== $confirmPassword) {
            Session::flash('error', 'Passwords do not match.');
            $this->redirect('/register');
            return;
        }

        if (strlen($password) < 6) {
            Session::flash('error', 'Password must be at least 6 characters.');
            $this->redirect('/register');
            return;
        }

        if ($this->userModel->findByEmail($email)) {
            Session::flash('error', 'Email already registered.');
            $this->redirect('/register');
            return;
        }

        if ($this->userModel->findByUsername($username)) {
            Session::flash('error', 'Username already taken.');
            $this->redirect('/register');
            return;
        }

        // Create user
        try {
            $this->userModel->createUser([
                'email' => $email,
                'username' => $username,
                'password' => $password,
            ]);

            Session::flash('success', 'Registration successful! Please login.');
            $this->redirect('/login');
        } catch (Exception $e) {
            Session::flash('error', 'Registration failed. Please try again.');
            $this->redirect('/register');
        }
    }

    /**
     * Handle logout
     */
    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/');
    }
}

