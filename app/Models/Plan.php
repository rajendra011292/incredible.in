<?php

namespace App\Models;

use App\Core\Database;

class Plan {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAllByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT p.*, s.name as setup_name 
             FROM plans p 
             LEFT JOIN setups s ON p.setup_id = s.id 
             WHERE p.user_id = ? 
             ORDER BY p.created_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findPendingByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT * FROM plans WHERE user_id = ? AND status = 'pending'",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id, int $userId): ?array {
        $stmt = $this->db->query(
            "SELECT p.*, s.name as setup_name 
             FROM plans p 
             LEFT JOIN setups s ON p.setup_id = s.id 
             WHERE p.id = ? AND p.user_id = ?",
            [$id, $userId]
        );
        $plan = $stmt->fetch();
        return $plan ?: null;
    }

    public function create(array $data): int {
        $this->db->query(
            "INSERT INTO plans (user_id, setup_id, symbol, direction, entry_price, stop_loss, take_profit, position_size, notes) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['user_id'], $data['setup_id'], $data['symbol'], $data['direction'],
                $data['entry_price'], $data['stop_loss'], $data['take_profit'],
                $data['position_size'], $data['notes']
            ]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }

    public function update(int $id, int $userId, array $data): bool {
        $stmt = $this->db->query(
            "UPDATE plans SET setup_id = ?, symbol = ?, direction = ?, entry_price = ?, 
             stop_loss = ?, take_profit = ?, position_size = ?, notes = ? 
             WHERE id = ? AND user_id = ? AND status = 'pending'",
            [
                $data['setup_id'], $data['symbol'], $data['direction'], $data['entry_price'],
                $data['stop_loss'], $data['take_profit'], $data['position_size'],
                $data['notes'], $id, $userId
            ]
        );
        return $stmt->rowCount() > 0;
    }

    public function updateStatus(int $id, string $status, ?int $userId = null): bool {
        if ($userId) {
            $stmt = $this->db->query(
                "UPDATE plans SET status = ? WHERE id = ? AND user_id = ?",
                [$status, $id, $userId]
            );
        } else {
            $stmt = $this->db->query(
                "UPDATE plans SET status = ? WHERE id = ?",
                [$status, $id]
            );
        }
        return $stmt->rowCount() > 0;
    }
}