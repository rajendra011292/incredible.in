<?php
ob_start();
use App\Core\Session;
?>
<div class="px-4 py-6">
    <h1 class="text-3xl font-bold mb-8">Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-2">Trading Setups</h3>
            <p class="text-4xl font-bold"><?= $setupCount ?></p>
        </div>

        <div class="bg-yellow-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-2">Pending Plans</h3>
            <p class="text-4xl font-bold"><?= $pendingPlans ?></p>
        </div>

        <div class="bg-green-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-2">Open Positions</h3>
            <p class="text-4xl font-bold"><?= count($openPositions) ?></p>
        </div>

        <div class="bg-<?= $stats['total_pnl'] >= 0 ? 'green' : 'red' ?>-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-2">Total P&L</h3>
            <p class="text-4xl font-bold">$<?= number_format($stats['total_pnl'], 2) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Open Positions</h2>
            <?php if (empty($openPositions)): ?>
                <p class="text-gray-500">No open positions</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($openPositions as $pos): ?>
                    <a href="/positions/<?= $pos['id'] ?>" class="block border-l-4 border-<?= $pos['direction'] === 'long' ? 'green' : 'red' ?>-500 pl-4 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-semibold"><?= htmlspecialchars($pos['symbol']) ?></span>
                            <span class="text-sm text-gray-500"><?= strtoupper($pos['direction']) ?></span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Entry: $<?= number_format($pos['entry_price'], 2) ?> | Size: <?= $pos['current_size'] ?>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Recent Journal Entries</h2>
            <?php if (empty($recentEntries)): ?>
                <p class="text-gray-500">No journal entries yet</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentEntries as $entry): ?>
                    <div class="border-b pb-2">
                        <div class="flex justify-between">
                            <span class="font-semibold"><?= htmlspecialchars($entry['symbol']) ?></span>
                            <span class="text-sm <?= $entry['pnl'] >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                                $<?= number_format($entry['pnl'], 2) ?>
                            </span>
                        </div>
                        <div class="text-xs text-gray-500">
                            <?= ucfirst(str_replace('_', ' ', $entry['action_type'])) ?> | 
                            <?= date('M d, Y H:i', strtotime($entry['created_at'])) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/setups/create" class="bg-blue-500 hover:bg-blue-600 text-white text-center py-3 rounded-lg font-semibold">
            Create Setup
        </a>
        <a href="/plans/create" class="bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 rounded-lg font-semibold">
            Create Plan
        </a>
        <a href="/journal" class="bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg font-semibold">
            View Journal
        </a>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Dashboard';
require __DIR__ . '/../layout/layout.php';
?>