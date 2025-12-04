<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="mb-6">
        <a href="/journal" class="text-blue-500 hover:text-blue-600">&larr; Back to Journal</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6">Journal Entry #<?= $entry['id'] ?></h1>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-500 uppercase mb-1">Symbol</p>
                <p class="text-2xl font-bold"><?= htmlspecialchars($entry['symbol']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase mb-1">Direction</p>
                <p class="text-2xl font-bold text-<?= $entry['direction'] === 'long' ? 'green' : 'red' ?>-600">
                    <?= strtoupper($entry['direction']) ?>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Action Type</p>
                <p class="font-semibold"><?= ucfirst(str_replace('_', ' ', $entry['action_type'])) ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Size</p>
                <p class="font-semibold"><?= number_format($entry['size'], 2) ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-500 mb-1">Price</p>
                <p class="font-semibold">$<?= number_format($entry['price'], 2) ?></p>
            </div>
        </div>

        <div class="bg-<?= $entry['pnl'] >= 0 ? 'green' : 'red' ?>-50 p-6 rounded mb-6">
            <p class="text-lg text-gray-700 mb-2">Profit/Loss</p>
            <p class="text-4xl font-bold text-<?= $entry['pnl'] >= 0 ? 'green' : 'red' ?>-600">
                $<?= number_format($entry['pnl'], 2) ?>
            </p>
        </div>

        <?php if ($entry['notes']): ?>
        <div class="bg-gray-50 p-4 rounded mb-6">
            <p class="text-sm text-gray-500 mb-2">Notes</p>
            <p class="text-gray-700"><?= htmlspecialchars($entry['notes']) ?></p>
        </div>
        <?php endif; ?>

        <div class="text-sm text-gray-500">
            <p>Created: <?= date('F d, Y \a\t H:i', strtotime($entry['created_at'])) ?></p>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Journal Entry';
require __DIR__ . '/../layout/layout.php';
?>
