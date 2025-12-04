<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="mb-6">
        <a href="/positions" class="text-blue-500 hover:text-blue-600">&larr; Back to Positions</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($position['symbol']) ?></h1>
                <p class="text-gray-600">Position #<?= $position['id'] ?></p>
            </div>
            <span class="px-4 py-2 rounded-full text-lg font-semibold
                <?= $position['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                <?= ucfirst($position['status']) ?>
            </span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Direction</p>
                <p class="text-xl font-bold text-<?= $position['direction'] === 'long' ? 'green' : 'red' ?>-600">
                    <?= strtoupper($position['direction']) ?>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Entry Price</p>
                <p class="text-xl font-bold">$<?= number_format($position['entry_price'], 2) ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Original Size</p>
                <p class="text-xl font-bold"><?= number_format($position['original_size'], 2) ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Current Size</p>
                <p class="text-xl font-bold"><?= number_format($position['current_size'], 2) ?></p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="bg-red-50 p-4 rounded">
                <p class="text-sm text-gray-700 mb-1">Stop Loss</p>
                <p class="text-2xl font-bold text-red-600">$<?= number_format($position['stop_loss'], 2) ?></p>
            </div>
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-700 mb-1">Take Profit</p>
                <p class="text-2xl font-bold text-green-600">$<?= number_format($position['take_profit'], 2) ?></p>
            </div>
        </div>

        <div class="bg-<?= $position['realized_pnl'] >= 0 ? 'green' : 'red' ?>-50 p-6 rounded">
            <p class="text-lg text-gray-700 mb-2">Total Realized P&L</p>
            <p class="text-4xl font-bold text-<?= $position['realized_pnl'] >= 0 ? 'green' : 'red' ?>-600">
                $<?= number_format($position['realized_pnl'], 2) ?>
            </p>
        </div>
    </div>

    <?php if ($position['status'] === 'open'): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Partial Close Form -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Partial Close</h2>
            <form action="/positions/<?= $position['id'] ?>/partial-close" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Close Size</label>
                    <input type="number" step="0.01" name="close_size" required
                           max="<?= $position['current_size'] ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                           placeholder="Max: <?= $position['current_size'] ?>">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Close Price</label>
                    <input type="number" step="0.01" name="close_price" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">
                    Partial Close
                </button>
            </form>
        </div>

        <!-- Full Close Form -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Full Close</h2>
            <form action="/positions/<?= $position['id'] ?>/close" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Close Price</label>
                    <input type="number" step="0.01" name="close_price" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <div class="mb-4 bg-red-50 p-3 rounded">
                    <p class="text-sm text-red-700">
                        This will close the entire position (<?= $position['current_size'] ?> units)
                    </p>
                </div>

                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg"
                        onclick="return confirm('Close entire position?')">
                    Close Position
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Journal Entries -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Trade History</h2>
        
        <?php if (empty($entries)): ?>
            <p class="text-gray-500">No history yet</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($entries as $entry): ?>
                <div class="border-l-4 border-<?= $entry['action_type'] === 'open' ? 'blue' : ($entry['pnl'] >= 0 ? 'green' : 'red') ?>-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-800">
                                <?= ucfirst(str_replace('_', ' ', $entry['action_type'])) ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                Size: <?= number_format($entry['size'], 2) ?> @ $<?= number_format($entry['price'], 2) ?>
                            </p>
                            <?php if ($entry['notes']): ?>
                            <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($entry['notes']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg text-<?= $entry['pnl'] >= 0 ? 'green' : 'red' ?>-600">
                                <?php 
                                if (isset($entry['pnl']) && $entry['pnl'] != 0) {
                                    $pnl = number_format((float)$entry['pnl'], 2);
                                    $pnlPercent = isset($entry['pnl_percent']) ? number_format((float)$entry['pnl_percent'], 2) : '0.00';
                                    echo "$pnl ($pnlPercent%)";
                                } else {
                                    echo '-';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Position Details';
require __DIR__ . '/../layout/layout.php';
?>