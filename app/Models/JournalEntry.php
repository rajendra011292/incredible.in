<?php

namespace App\Models;

use App\Core\Database;

class JournalEntry {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAllByUser(int $userId): array {
        $stmt = $this->db->query(
            "SELECT j.*, p.symbol, p.direction 
             FROM journal_entries j 
             JOIN positions p ON j.position_id = p.id 
             WHERE j.user_id = ? 
             ORDER BY j.created_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    public function findRecentByUser(int $userId, int $limit): array {
        $stmt = $this->db->query(
            "SELECT j.*, p.symbol, p.direction 
             FROM journal_entries j 
             JOIN positions p ON j.position_id = p.id 
             WHERE j.user_id = ? 
             ORDER BY j.created_at DESC 
             LIMIT ?",
            [$userId, $limit]
        );
        return $stmt->fetchAll();
    }

    public function findByPosition(int $positionId): array {
        $stmt = $this->db->query(
            "SELECT * FROM journal_entries WHERE position_id = ? ORDER BY created_at ASC",
            [$positionId]
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id, int $userId): ?array {
        $stmt = $this->db->query(
            "SELECT j.*, p.symbol, p.direction 
             FROM journal_entries j 
             JOIN positions p ON j.position_id = p.id 
             WHERE j.id = ? AND j.user_id = ?",
            [$id, $userId]
        );
        $entry = $stmt->fetch();
        return $entry ?: null;
    }

    public function create(array $data): int {
        $this->db->query(
            "INSERT INTO journal_entries (user_id, position_id, action_type, size, price, pnl, notes) 
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                $data['user_id'], $data['position_id'], $data['action_type'],
                $data['size'], $data['price'], $data['pnl'], $data['notes']
            ]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }
}