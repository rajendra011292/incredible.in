<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Trade Plans</h1>
        <a href="/plans/create" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold">
            Create Plan
        </a>
    </div>

    <?php if (empty($plans)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 mb-4">No trade plans yet</p>
            <a href="/plans/create" class="text-yellow-500 hover:text-yellow-600 font-semibold">Create your first plan</a>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($plans as $plan): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="flex">
                    <div class="w-2 bg-<?= $plan['status'] === 'pending' ? 'yellow' : ($plan['status'] === 'executed' ? 'green' : 'red') ?>-500"></div>
                    
                    <div class="flex-1 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($plan['symbol']) ?></h3>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($plan['setup_name'] ?? 'No Setup') ?></p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    <?= $plan['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($plan['status'] === 'executed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst($plan['status']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Direction</p>
                                <p class="font-semibold text-<?= $plan['direction'] === 'long' ? 'green' : 'red' ?>-600">
                                    <?= strtoupper($plan['direction']) ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Entry Price</p>
                                <p class="font-semibold">$<?= number_format($plan['entry_price'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Stop Loss</p>
                                <p class="font-semibold text-red-600">$<?= number_format($plan['stop_loss'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Take Profit</p>
                                <p class="font-semibold text-green-600">$<?= number_format($plan['take_profit'], 2) ?></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-xs text-gray-500 uppercase mb-1">Position Size</p>
                            <p class="font-semibold"><?= number_format($plan['position_size'], 2) ?> units</p>
                        </div>

                        <?php if ($plan['notes']): ?>
                        <div class="bg-gray-50 p-3 rounded mb-4">
                            <p class="text-sm text-gray-700"><?= htmlspecialchars($plan['notes']) ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if ($plan['status'] === 'pending'): ?>
                        <div class="flex gap-2">
                            <form action="/plans/<?= $plan['id'] ?>/execute" method="POST" class="flex-1">
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded font-semibold"
                                        onclick="return confirm('Execute this plan and open position?')">
                                    Execute Plan
                                </button>
                            </form>
                            <a href="/plans/<?= $plan['id'] ?>/edit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded font-semibold">
                                Edit
                            </a>
                            <form action="/plans/<?= $plan['id'] ?>/cancel" method="POST" class="flex-1">
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold"
                                        onclick="return confirm('Cancel this plan?')">
                                    Cancel
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Trade Plans';
require __DIR__ . '/../layout/layout.php';
?>