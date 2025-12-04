<?php

namespace App\Core;

class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require_once __DIR__ . '/../../views/' . $view . '.php';
    }

    protected function redirect(string $path): void {
        header("Location: $path");
        exit;
    }

    protected function requireAuth(): void {
        if (!Session::isAuthenticated()) {
            $this->redirect('/login');
        }
    }

    protected function json(array $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}