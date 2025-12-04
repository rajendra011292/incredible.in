<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Create Trading Setup</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="/setups" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Setup Name</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Breakout Strategy">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe your trading setup..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Strategy Rules</label>
                    <textarea name="strategy" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Enter your trading rules and criteria..."></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                        Create Setup
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
$title = 'Create Plan';
require __DIR__ . '/../layout/layout.php';
?>