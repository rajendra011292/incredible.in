<?php
use App\Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Trading Journal' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php if (Session::isAuthenticated()): ?>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/dashboard" class="text-xl font-bold text-indigo-600">Trading Journal</a>
                    </div>
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/dashboard" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <a href="/setups" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Setups</a>
                        <a href="/plans" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Plans</a>
                        <a href="/positions" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Positions</a>
                        <a href="/journal" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Journal</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4"><?= Session::get('username') ?></span>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <?php if ($message = Session::getFlash('success')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?= htmlspecialchars($message) ?>
        </div>
        <?php endif; ?>

        <?php if ($message = Session::getFlash('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?= htmlspecialchars($message) ?>
        </div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>