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

    /**
     * Calculate trade metrics based on input data
     * 
     * @param array $data Input data containing trade parameters
     * @return array Array with calculated metrics
     */
    private function calculateTradeMetrics(array $data): array {
        $entryPrice = (float)($data['entry_price'] ?? 0);
        $stopLoss = (float)($data['stop_loss'] ?? 0);
        $takeProfit = (float)($data['take_profit'] ?? 0);
        $capital = (float)($data['capital'] ?? 0);
        $riskPercent = (float)($data['risk'] ?? 0);
        $direction = $data['direction'] ?? 'long';

        // Calculate risk per share (absolute difference between entry and stop loss)
        $riskPerShare = abs($entryPrice - $stopLoss);
        
        // Calculate risk per trade (capital * risk percent / 100)
        $riskPerTrade = $capital * ($riskPercent / 100);
        
        // Calculate position size (number of shares)
        $positionSize = $riskPerShare > 0 ? floor($riskPerTrade / $riskPerShare) : 0;
        
        // Calculate risk-reward ratio
        $riskRewardRatio = 0;
        if ($riskPerShare > 0) {
            $profit = $direction === 'long' 
                ? $takeProfit - $entryPrice 
                : $entryPrice - $takeProfit;
            $riskRewardRatio = $profit / $riskPerShare;
        }

        return [
            'risk_per_share' => $riskPerShare,
            'risk_per_trade' => $riskPerTrade,
            'position_size' => $positionSize,
            'risk_reward_ratio' => $riskRewardRatio,
            'capital_used' => $positionSize * $entryPrice
        ];
    }

    public function create(array $data): int {
        // Calculate all metrics
        $metrics = $this->calculateTradeMetrics($data);
        
        // Prepare data for storage
        $dataToStore = [
            'user_id' => $data['user_id'],
            'setup_id' => (int)($data['setup_id'] ?? 0),
            'symbol' => strtoupper($data['symbol'] ?? ''),
            'sector' => $data['sector'] ?? null,
            'industry' => $data['industry'] ?? null,
            'direction' => $data['direction'] ?? 'long',
            'timeframe' => $data['timeframe'] ?? null,
            'entry_timeframe' => $data['entry_timeframe'] ?? null,
            'trend' => $data['trend'] ?? null,
            'emotion' => $data['emotion'] ?? null,
            'confidence' => isset($data['confidence']) ? (int)$data['confidence'] : 0,
            'entry_price' => (float)($data['entry_price'] ?? 0),
            'stop_loss' => (float)($data['stop_loss'] ?? 0),
            'take_profit' => (float)($data['take_profit'] ?? 0),
            'capital' => (float)($data['capital'] ?? 0),
            'risk' => (float)($data['risk'] ?? 0),
            'trade_date' => $data['trade_date'] ?? date('Y-m-d H:i:s'),
            'notes' => $data['notes'] ?? '',
            // Calculated fields
            'risk_per_share' => $metrics['risk_per_share'],
            'risk_per_trade' => $metrics['risk_per_trade'],
            'position_size' => $metrics['position_size'],
            'risk_reward_ratio' => $metrics['risk_reward_ratio'],
            'capital_used' => $metrics['capital_used']
        ];

        return $this->planModel->create($dataToStore);
    }

    public function update(int $id, int $userId, array $data): bool {
        // Calculate all metrics
        $metrics = $this->calculateTradeMetrics($data);
        
        // Prepare data for update
        $dataToUpdate = [
            'setup_id' => (int)($data['setup_id'] ?? 0),
            'symbol' => strtoupper($data['symbol'] ?? ''),
            'sector' => $data['sector'] ?? null,
            'industry' => $data['industry'] ?? null,
            'direction' => $data['direction'] ?? 'long',
            'timeframe' => $data['timeframe'] ?? null,
            'entry_timeframe' => $data['entry_timeframe'] ?? null,
            'trend' => $data['trend'] ?? null,
            'emotion' => $data['emotion'] ?? null,
            'confidence' => isset($data['confidence']) ? (int)$data['confidence'] : 0,
            'entry_price' => (float)($data['entry_price'] ?? 0),
            'stop_loss' => (float)($data['stop_loss'] ?? 0),
            'take_profit' => (float)($data['take_profit'] ?? 0),
            'capital' => (float)($data['capital'] ?? 0),
            'risk' => (float)($data['risk'] ?? 0),
            'notes' => $data['notes'] ?? '',
            // Calculated fields
            'risk_per_share' => $metrics['risk_per_share'],
            'risk_per_trade' => $metrics['risk_per_trade'],
            'position_size' => $metrics['position_size'],
            'risk_reward_ratio' => $metrics['risk_reward_ratio'],
            'capital_used' => $metrics['capital_used']
        ];

        return $this->planModel->update($id, $userId, $dataToUpdate);
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
            'take_profit' => $plan['take_profit'],
            'capital' => $plan['capital'],
            'risk' => $plan['risk']
        ]);

        // Create journal entry
        $this->journalModel->create([
            'user_id' => $userId,
            'position_id' => $positionId,
            'action_type' => 'open',
            'size' => $plan['position_size'],
            'price' => $plan['entry_price'],
            'pnl' => 0,
            'notes' => 'Position opened from plan execution',
            'capital' => $plan['capital'],
            'risk' => $plan['risk']
        ]);

        // Mark plan as executed
        $this->planModel->updateStatus($id, 'executed');

        return ['success' => true, 'position_id' => $positionId];
    }

    public function cancel(int $id, int $userId): bool {
        return $this->planModel->updateStatus($id, 'cancelled', $userId);
    }
}