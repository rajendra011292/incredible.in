<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\AuthService;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function showLogin(): void {
        if (Session::isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }

    public function showRegister(): void {
        if (Session::isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/register');
    }

    public function login(): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->authService->login($email, $password);

        if ($user) {
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            Session::setFlash('success', 'Welcome back, ' . $user['username'] . '!');
            $this->redirect('/dashboard');
        } else {
            Session::setFlash('error', 'Invalid email or password');
            $this->redirect('/login');
        }
    }

    public function register(): void {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            Session::setFlash('error', 'Passwords do not match');
            $this->redirect('/register');
            return;
        }

        $result = $this->authService->register($username, $email, $password);

        if ($result['success']) {
            Session::setFlash('success', 'Registration successful! Please log in.');
            $this->redirect('/login');
        } else {
            Session::setFlash('error', $result['message']);
            $this->redirect('/register');
        }
    }

    public function logout(): void {
        Session::destroy();
        $this->redirect('/login');
    }
}