<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Position;
use App\Models\JournalEntry;

class PlanService {
    private Plan $planModel;
    private Position $positionModel;
    private JournalEntry $journalModel;

    public function __construct() {
        $this->planModel = new Plan();
        $this->positionModel = new Position();
        $this->journalModel = new JournalEntry();
    }

    public function getAllForUser(int $userId): array {
        return $this->planModel->findAllByUser($userId);
    }

    public function getById(int $id, int $userId): ?array {
        return $this->planModel->findById($id, $userId);
    }

    public function getPendingCount(int $userId): int {
        return count($this->planModel->findPendingByUser($userId));
    }

    public function create(array $data): int {
        return $this->planModel->create($data);
    }

    public function update(int $id, int $userId, array $data): bool {
        return $this->planModel->update($id, $userId, $data);
    }

    public function execute(int $id, int $userId): array {
        $plan = $this->planModel->findById($id, $userId);
        
        if (!$plan) {
            return ['success' => false, 'message' => 'Plan not found'];
        }

        if ($plan['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Plan already executed or cancelled'];
        }

        // Create position
        $positionId = $this->positionModel->create([
            'user_id' => $userId,
            'plan_id' => $id,
            'symbol' => $plan['symbol'],
            'direction' => $plan['direction'],
            'entry_price' => $plan['entry_price'],
            'current_size' => $plan['position_size'],
            'original_size' => $plan['position_size'],
            'stop_loss' => $plan['stop_loss'],
            'take_profit' => $plan['take_profit']
        ]);

        // Create journal entry
        $this->journalModel->create([
            'user_id' => $userId,
            'position_id' => $positionId,
            'action_type' => 'open',
            'size' => $plan['position_size'],
            'price' => $plan['entry_price'],
            'pnl' => 0,
            'notes' => 'Position opened from plan execution'
        ]);

        // Mark plan as executed
        $this->planModel->updateStatus($id, 'executed');

        return ['success' => true, 'position_id' => $positionId];
    }

    public function cancel(int $id, int $userId): bool {
        return $this->planModel->updateStatus($id, 'cancelled', $userId);
    }
}