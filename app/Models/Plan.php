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
            "INSERT INTO plans (
                user_id, setup_id, symbol, sector, industry, direction, timeframe, entry_timeframe,
                trend, emotion, confidence, entry_price, stop_loss, take_profit, capital, risk,
                risk_per_share, risk_per_trade, position_size, risk_reward_ratio, capital_used, 
                trade_date, notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['user_id'], 
                $data['setup_id'] ?? null, 
                $data['symbol'], 
                $data['sector'] ?? null,
                $data['industry'] ?? null,
                $data['direction'] ?? 'long',
                $data['timeframe'] ?? null,
                $data['entry_timeframe'] ?? null,
                $data['trend'] ?? null,
                $data['emotion'] ?? null,
                $data['confidence'] ?? 50,
                $data['entry_price'],
                $data['stop_loss'],
                $data['take_profit'],
                $data['capital'],
                $data['risk'],
                $data['risk_per_share'] ?? null,
                $data['risk_per_trade'] ?? null,
                $data['position_size'],
                $data['risk_reward_ratio'] ?? null,
                $data['capital_used'] ?? null,
                $data['trade_date'] ?? date('Y-m-d H:i:s'),
                $data['notes'] ?? ''
            ]
        );
        return (int) $this->db->getConnection()->lastInsertId();
    }

    public function update(int $id, int $userId, array $data): bool {
        $stmt = $this->db->query(
            "UPDATE plans SET 
                setup_id = ?, 
                symbol = ?, 
                sector = ?,
                industry = ?,
                direction = ?, 
                timeframe = ?,
                entry_timeframe = ?,
                trend = ?,
                emotion = ?,
                confidence = ?,
                entry_price = ?, 
                stop_loss = ?, 
                take_profit = ?, 
                capital = ?, 
                risk = ?,
                risk_per_share = ?,
                risk_per_trade = ?,
                position_size = ?,
                risk_reward_ratio = ?,
                capital_used = ?,
                trade_date = ?,
                notes = ?,
                updated_at = CURRENT_TIMESTAMP
             WHERE id = ? AND user_id = ? AND status = 'pending'",
            [
                $data['setup_id'] ?? null,
                $data['symbol'],
                $data['sector'] ?? null,
                $data['industry'] ?? null,
                $data['direction'] ?? 'long',
                $data['timeframe'] ?? null,
                $data['entry_timeframe'] ?? null,
                $data['trend'] ?? null,
                $data['emotion'] ?? null,
                $data['confidence'] ?? 50,
                $data['entry_price'],
                $data['stop_loss'],
                $data['take_profit'],
                $data['capital'],
                $data['risk'],
                $data['risk_per_share'] ?? null,
                $data['risk_per_trade'] ?? null,
                $data['position_size'],
                $data['risk_reward_ratio'] ?? null,
                $data['capital_used'] ?? null,
                $data['trade_date'] ?? date('Y-m-d H:i:s'),
                $data['notes'] ?? '',
                $id, 
                $userId
            ]
        );
        return $stmt->rowCount() > 0;
    }

    public function updateStatus(int $id, string $status, ?int $userId = null): bool {
        $params = [$status, $id];
        $sql = "UPDATE plans SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        
        if ($userId) {
            $sql .= " AND user_id = ?";
            $params[] = $userId;
        }
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }
}