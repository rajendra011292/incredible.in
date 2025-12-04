<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Trade Plan</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="/plans/<?= $plan['id'] ?>/update" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Trading Setup</label>
                    <select name="setup_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <?php foreach ($setups as $setup): ?>
                        <option value="<?= $setup['id'] ?>" <?= $setup['id'] == $plan['setup_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($setup['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Symbol</label>
                        <input type="text" name="symbol" required value="<?= htmlspecialchars($plan['symbol']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Direction</label>
                        <select name="direction" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="long" <?= $plan['direction'] === 'long' ? 'selected' : '' ?>>Long</option>
                            <option value="short" <?= $plan['direction'] === 'short' ? 'selected' : '' ?>>Short</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Entry Price</label>
                        <input type="number" step="0.01" name="entry_price" required value="<?= $plan['entry_price'] ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stop Loss</label>
                        <input type="number" step="0.01" name="stop_loss" required value="<?= $plan['stop_loss'] ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Take Profit</label>
                        <input type="number" step="0.01" name="take_profit" required value="<?= $plan['take_profit'] ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Position Size</label>
                    <input type="number" step="0.01" name="position_size" required value="<?= $plan['position_size'] ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"><?= htmlspecialchars($plan['notes']) ?></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">
                        Update Plan
                    </button>
                    <a href="/plans" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Edit Plan';
require __DIR__ . '/../layout/layout.php';
?>