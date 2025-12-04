<?php

namespace App\Services;

use App\Models\JournalEntry;

class JournalService {
    private JournalEntry $journalModel;

    public function __construct() {
        $this->journalModel = new JournalEntry();
    }

    public function getAllForUser(int $userId): array {
        return $this->journalModel->findAllByUser($userId);
    }

    public function getById(int $id, int $userId): ?array {
        return $this->journalModel->findById($id, $userId);
    }

    public function getRecent(int $userId, int $limit = 10): array {
        return $this->journalModel->findRecentByUser($userId, $limit);
    }

    public function getStats(int $userId): array {
        $entries = $this->journalModel->findAllByUser($userId);
        
        $totalTrades = 0;
        $totalPnl = 0;
        $winningTrades = 0;
        $losingTrades = 0;

        foreach ($entries as $entry) {
            if ($entry['action_type'] === 'full_close' || $entry['action_type'] === 'partial_close') {
                $totalTrades++;
                $totalPnl += $entry['pnl'];
                
                if ($entry['pnl'] > 0) {
                    $winningTrades++;
                } elseif ($entry['pnl'] < 0) {
                    $losingTrades++;
                }
            }
        }

        $winRate = $totalTrades > 0 ? ($winningTrades / $totalTrades) * 100 : 0;

        return [
            'total_trades' => $totalTrades,
            'total_pnl' => $totalPnl,
            'winning_trades' => $winningTrades,
            'losing_trades' => $losingTrades,
            'win_rate' => round($winRate, 2)
        ];
    }
}