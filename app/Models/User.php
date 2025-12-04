<?php

namespace App\Models;

use App\Core\Database;

class User {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->query(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->query(
            "SELECT * FROM users WHERE username = ?",
            [$username]
        );
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $username, string $email, string $password): int {
        $this->db->query(
            "INSERT INTO users (username, email, password) VALUES (?, ?, ?)",
            [$username, $email, $password]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }
}