<?php

namespace App\Services;

use App\Models\User;

class AuthService {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login(string $email, string $password): ?array {
        $user = $this->userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return null;
    }

    public function register(string $username, string $email, string $password): array {
        if ($this->userModel->findByEmail($email)) {
            return ['success' => false, 'message' => 'Email already exists'];
        }

        if ($this->userModel->findByUsername($username)) {
            return ['success' => false, 'message' => 'Username already exists'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->create($username, $email, $hashedPassword);
        
        return ['success' => true, 'message' => 'Registration successful'];
    }
}