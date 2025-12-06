<?php
ob_start();
$title = 'Trade Plan Details';
$user = $_SESSION['user'] ?? null;
?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Trade Plan Details</h1>
        <div class="space-x-2">
            <a href="/plans" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                Back to Plans
            </a>
            <?php if ($plan['status'] === 'pending'): ?>
                <a href="/plans/<?= $plan['id'] ?>/edit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                    Edit Plan
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($plan['symbol']) ?></h2>
                    <div class="flex items-center mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?= $plan['direction'] === 'long' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= ucfirst($plan['direction']) ?>
                        </span>
                        <span class="ml-2 text-sm text-gray-500">
                            Created on <?= date('M d, Y \a\t H:i', strtotime($plan['created_at'])) ?>
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        <?= $plan['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($plan['status'] === 'executed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                        <?= ucfirst($plan['status']) ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <!-- Trade Details -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Trade Details</h3>
                <div>
                    <p class="text-sm text-gray-500">Sector</p>
                    <p class="font-medium"><?= htmlspecialchars($plan['sector'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Industry</p>
                    <p class="font-medium"><?= htmlspecialchars($plan['industry'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Timeframe</p>
                    <p class="font-medium"><?= htmlspecialchars($plan['timeframe'] ?? 'N/A') ?></p>
                </div>
            </div>

            <!-- Price Levels -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Price Levels</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Entry Price</p>
                        <p class="font-medium">₹<?= number_format($plan['entry_price'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Stop Loss</p>
                        <p class="font-medium">₹<?= number_format($plan['stop_loss'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Take Profit</p>
                        <p class="font-medium">₹<?= number_format($plan['take_profit'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Risk:Reward</p>
                        <p class="font-medium">1:<?= number_format($plan['risk_reward_ratio'] ?? 0, 2) ?></p>
                    </div>
                </div>
            </div>

            <!-- Risk Management -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Risk Management</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Capital</p>
                        <p class="font-medium">₹<?= number_format($plan['capital'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Risk %</p>
                        <p class="font-medium"><?= $plan['risk'] ?>%</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Position Size</p>
                        <p class="font-medium"><?= number_format($plan['position_size']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Risk/Trade</p>
                        <p class="font-medium">₹<?= number_format($plan['risk_per_trade'] ?? 0, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Context & Notes -->
        <div class="px-6 py-4 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Market Context</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Trend</p>
                    <p class="font-medium"><?= ucfirst($plan['trend'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Market Emotion</p>
                    <p class="font-medium"><?= ucfirst($plan['emotion'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Confidence</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        <div class="bg-yellow-500 h-2.5 rounded-full" 
                             style="width: <?= $plan['confidence'] ?? 0 ?>%"></div>
                    </div>
                    <p class="text-sm text-gray-500 text-right"><?= $plan['confidence'] ?? 0 ?>%</p>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 mb-3">Notes</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <?= nl2br(htmlspecialchars($plan['notes'] ?: 'No notes available.')) ?>
            </div>
        </div>
    </div>

    <?php if ($plan['status'] === 'pending'): ?>
    <div class="flex justify-end space-x-4 mt-6">
        <form action="/plans/<?= $plan['id'] ?>/cancel" method="POST" class="inline" 
              onsubmit="return confirm('Are you sure you want to cancel this trade plan?');">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">
                Cancel Plan
            </button>
        </form>
        <form action="/plans/<?= $plan['id'] ?>/execute" method="POST" class="inline"
              onsubmit="return confirm('Execute this trade plan? This action cannot be undone.');">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                Execute Trade
            </button>
        </form>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/layout.php';
?>