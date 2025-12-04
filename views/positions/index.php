<?php
ob_start();
?>
<div class="px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Positions</h1>

    <?php if (empty($positions)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 mb-4">No positions yet</p>
            <a href="/plans" class="text-green-500 hover:text-green-600 font-semibold">Execute a plan to open a position</a>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($positions as $position): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="flex">
                    <div class="w-2 bg-<?= $position['status'] === 'open' ? 'green' : 'gray' ?>-500"></div>
                    
                    <div class="flex-1 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($position['symbol']) ?></h3>
                                <p class="text-sm text-gray-500">Opened: <?= date('M d, Y H:i', strtotime($position['opened_at'])) ?></p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    <?= $position['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                    <?= ucfirst($position['status']) ?>
                                </span>
                                <p class="text-sm mt-1 font-semibold text-<?= $position['direction'] === 'long' ? 'green' : 'red' ?>-600">
                                    <?= strtoupper($position['direction']) ?>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Entry Price</p>
                                <p class="font-semibold">$<?= number_format($position['entry_price'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Current Size</p>
                                <p class="font-semibold"><?= number_format($position['current_size'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Stop Loss</p>
                                <p class="font-semibold text-red-600">$<?= number_format($position['stop_loss'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Take Profit</p>
                                <p class="font-semibold text-green-600">$<?= number_format($position['take_profit'], 2) ?></p>
                            </div>
                        </div>

                        <div class="bg-<?= $position['realized_pnl'] >= 0 ? 'green' : 'red' ?>-50 p-4 rounded mb-4">
                            <p class="text-sm text-gray-700 mb-1">Realized P&L</p>
                            <p class="text-2xl font-bold text-<?= $position['realized_pnl'] >= 0 ? 'green' : 'red' ?>-600">
                                $<?= number_format($position['realized_pnl'], 2) ?>
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="/positions/<?= $position['id'] ?>" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded font-semibold">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Positions';
require __DIR__ . '/../layout/layout.php';
?>