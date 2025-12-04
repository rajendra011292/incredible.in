<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Trading Setup</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="/setups/<?= $setup['id'] ?>/update" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Setup Name</label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($setup['name']) ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($setup['description']) ?></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Strategy Rules</label>
                    <textarea name="strategy" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($setup['strategy']) ?></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                        Update Setup
                    </button>
                    <a href="/setups" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Edit Setup';
require __DIR__ . '/../layout/layout.php';
?>