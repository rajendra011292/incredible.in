<?php

namespace App\Services;

use App\Models\Position;
use App\Models\JournalEntry;

class PositionService {
    private Position $positionModel;
    private JournalEntry $journalModel;

    public function __construct() {
        $this->positionModel = new Position();
        $this->journalModel = new JournalEntry();
    }

    public function getAllForUser(int $userId): array {
        return $this->positionModel->findAllByUser($userId);
    }

    public function getOpenPositions(int $userId): array {
        return $this->positionModel->findOpenByUser($userId);
    }

    public function getById(int $id, int $userId): ?array {
        return $this->positionModel->findById($id, $userId);
    }

    public function getJournalEntries(int $positionId): array {
        return $this->journalModel->findByPosition($positionId);
    }

    public function closeFull(int $id, int $userId, float $closePrice, string $notes = ''): array {
        $position = $this->positionModel->findById($id, $userId);
        
        if (!$position) {
            return ['success' => false, 'message' => 'Position not found'];
        }

        if ($position['status'] === 'closed') {
            return ['success' => false, 'message' => 'Position already closed'];
        }

        $size = $position['current_size'];
        $pnl = $this->calculatePnL($position, $size, $closePrice);

        // Create journal entry
        $this->journalModel->create([
            'user_id' => $userId,
            'position_id' => $id,
            'action_type' => 'full_close',
            'size' => $size,
            'price' => $closePrice,
            'pnl' => $pnl,
            'notes' => $notes
        ]);

        // Update position
        $totalPnl = $position['realized_pnl'] + $pnl;
        $this->positionModel->close($id, $totalPnl);

        return ['success' => true, 'pnl' => $pnl];
    }

    public function closePartial(int $id, int $userId, float $closeSize, float $closePrice, string $notes = ''): array {
        $position = $this->positionModel->findById($id, $userId);
        
        if (!$position) {
            return ['success' => false, 'message' => 'Position not found'];
        }

        if ($position['status'] === 'closed') {
            return ['success' => false, 'message' => 'Position already closed'];
        }

        if ($closeSize > $position['current_size']) {
            return ['success' => false, 'message' => 'Close size exceeds current position size'];
        }

        $pnl = $this->calculatePnL($position, $closeSize, $closePrice);

        // Create journal entry
        $this->journalModel->create([
            'user_id' => $userId,
            'position_id' => $id,
            'action_type' => 'partial_close',
            'size' => $closeSize,
            'price' => $closePrice,
            'pnl' => $pnl,
            'notes' => $notes
        ]);

        // Update position
        $newSize = $position['current_size'] - $closeSize;
        $totalPnl = $position['realized_pnl'] + $pnl;
        $this->positionModel->updateSize($id, $newSize, $totalPnl);

        return ['success' => true, 'pnl' => $pnl];
    }

    private function calculatePnL(array $position, float $size, float $closePrice): float {
        $entryPrice = $position['entry_price'];
        $direction = $position['direction'];

        if ($direction === 'long') {
            return ($closePrice - $entryPrice) * $size;
        } else {
            return ($entryPrice - $closePrice) * $size;
        }
    }
}