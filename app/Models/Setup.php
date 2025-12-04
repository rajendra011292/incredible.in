<?php

namespace App\Models;

use App\Core\Database;

class Setup {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAllByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT * FROM setups WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id, int $userId): ?array {
        $stmt = $this->db->query(
            "SELECT * FROM setups WHERE id = ? AND user_id = ?",
            [$id, $userId]
        );
        $setup = $stmt->fetch();
        return $setup ?: null;
    }

    public function create(array $data): int {
        $this->db->query(
            "INSERT INTO setups (user_id, name, description, strategy) VALUES (?, ?, ?, ?)",
            [$data['user_id'], $data['name'], $data['description'], $data['strategy']]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }

    public function update(int $id, int $userId, array $data): bool {
        $stmt = $this->db->query(
            "UPDATE setups SET name = ?, description = ?, strategy = ? WHERE id = ? AND user_id = ?",
            [$data['name'], $data['description'], $data['strategy'], $id, $userId]
        );
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id, int $userId): bool {
        $stmt = $this->db->query(
            "DELETE FROM setups WHERE id = ? AND user_id = ?",
            [$id, $userId]
        );
        return $stmt->rowCount() > 0;
    }
}