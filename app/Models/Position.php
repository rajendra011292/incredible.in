<?php

namespace App\Models;

use App\Core\Database;

class Position {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAllByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT * FROM positions WHERE user_id = ? ORDER BY opened_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findOpenByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT * FROM positions WHERE user_id = ? AND status = 'open' ORDER BY opened_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id, int $userId): ?array {
        $stmt = $this->db->query(
            "SELECT * FROM positions WHERE id = ? AND user_id = ?",
            [$id, $userId]
        );
        $position = $stmt->fetch();
        return $position ?: null;
    }

    public function create(array $data): int {
        $this->db->query(
            "INSERT INTO positions (user_id, plan_id, symbol, direction, entry_price, current_size, original_size, stop_loss, take_profit) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['user_id'], $data['plan_id'], $data['symbol'], $data['direction'],
                $data['entry_price'], $data['current_size'], $data['original_size'],
                $data['stop_loss'], $data['take_profit']
            ]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }

    public function updateSize(int $id, float $newSize, float $realizedPnl): bool {
        $stmt = $this->db->query(
            "UPDATE positions SET current_size = ?, realized_pnl = ? WHERE id = ?",
            [$newSize, $realizedPnl, $id]
        );
        return $stmt->rowCount() > 0;
    }

    public function close(int $id, float $realizedPnl): bool {
        $stmt = $this->db->query(
            "UPDATE positions SET status = 'closed', current_size = 0, realized_pnl = ?, closed_at = NOW() WHERE id = ?",
            [$realizedPnl, $id]
        );
        return $stmt->rowCount() > 0;
    }
}