<?php
use App\Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Trading Journal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-2xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Trading Journal</h2>
        
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

        <form action="/login" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Login
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Don't have an account? <a href="/register" class="text-indigo-600 hover:text-indigo-800 font-semibold">Register</a>
        </p>
    </div>
</body>
</html>