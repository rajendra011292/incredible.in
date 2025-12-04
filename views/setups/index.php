<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Trading Setups</h1>
        <a href="/setups/create" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">
            Create Setup
        </a>
    </div>

    <?php if (empty($setups)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 mb-4">No trading setups yet</p>
            <a href="/setups/create" class="text-blue-500 hover:text-blue-600 font-semibold">Create your first setup</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($setups as $setup): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-500 text-white px-6 py-4">
                    <h3 class="text-xl font-bold"><?= htmlspecialchars($setup['name']) ?></h3>
                    <p class="text-sm text-blue-100"><?= date('M d, Y', strtotime($setup['created_at'])) ?></p>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4"><?= htmlspecialchars(substr($setup['description'], 0, 100)) ?><?= strlen($setup['description']) > 100 ? '...' : '' ?></p>
                    
                    <?php if ($setup['strategy']): ?>
                    <div class="bg-gray-50 p-3 rounded mb-4">
                        <p class="text-sm text-gray-600 font-semibold mb-1">Strategy:</p>
                        <p class="text-sm text-gray-700"><?= htmlspecialchars(substr($setup['strategy'], 0, 80)) ?><?= strlen($setup['strategy']) > 80 ? '...' : '' ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="flex gap-2">
                        <a href="/setups/<?= $setup['id'] ?>/edit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 rounded font-semibold">
                            Edit
                        </a>
                        <form action="/setups/<?= $setup['id'] ?>/delete" method="POST" class="flex-1" onsubmit="return confirm('Delete this setup?')">
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Trading Setups';
require __DIR__ . '/../layout/layout.php';
?>