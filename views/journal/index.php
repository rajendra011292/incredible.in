<?php
ob_start();
?>
<div class="px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Trading Journal</h1>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-blue-500 text-white rounded-lg p-4">
            <p class="text-sm mb-1">Total Trades</p>
            <p class="text-3xl font-bold"><?= $stats['total_trades'] ?></p>
        </div>
        <div class="bg-green-500 text-white rounded-lg p-4">
            <p class="text-sm mb-1">Winning Trades</p>
            <p class="text-3xl font-bold"><?= $stats['winning_trades'] ?></p>
        </div>
        <div class="bg-red-500 text-white rounded-lg p-4">
            <p class="text-sm mb-1">Losing Trades</p>
            <p class="text-3xl font-bold"><?= $stats['losing_trades'] ?></p>
        </div>
        <div class="bg-purple-500 text-white rounded-lg p-4">
            <p class="text-sm mb-1">Win Rate</p>
            <p class="text-3xl font-bold"><?= $stats['win_rate'] ?>%</p>
        </div>
        <div class="bg-<?= $stats['total_pnl'] >= 0 ? 'green' : 'red' ?>-500 text-white rounded-lg p-4">
            <p class="text-sm mb-1">Total P&L</p>
            <p class="text-3xl font-bold">$<?= number_format($stats['total_pnl'], 2) ?></p>
        </div>
    </div>

    <!-- Journal Entries -->
    <?php if (empty($entries)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 mb-4">No journal entries yet</p>
            <a href="/plans" class="text-blue-500 hover:text-blue-600 font-semibold">Start trading to build your journal</a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Symbol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Direction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Size</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">P&L</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Notes</th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($entries as $entry): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?= date('M d, Y', strtotime($entry['created_at'])) ?><br>
                                <span class="text-xs text-gray-400"><?= date('H:i', strtotime($entry['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                <?= htmlspecialchars($entry['symbol']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    <?= $entry['action_type'] === 'open' ? 'bg-blue-100 text-blue-800' : 
                                        ($entry['action_type'] === 'partial_close' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $entry['action_type'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-<?= $entry['direction'] === 'long' ? 'green' : 'red' ?>-600">
                                    <?= strtoupper($entry['direction']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?= number_format($entry['size'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                $<?= number_format($entry['price'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-<?= $entry['pnl'] >= 0 ? 'green' : 'red' ?>-600">
                                <?= $entry['pnl'] != 0 ? '$' . number_format($entry['pnl'], 2) : '-' ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= htmlspecialchars(substr($entry['notes'], 0, 50)) ?><?= strlen($entry['notes']) > 50 ? '...' : '' ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <a href="/journal/<?= $entry['id'] ?>" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Create Setup';
require __DIR__ . '/../layout/layout.php';
?>