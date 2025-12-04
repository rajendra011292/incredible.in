<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Database;
use App\Core\Router;
use App\Core\Session;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Start session
Session::start();

// Initialize database
Database::getInstance();

// Initialize router
$router = new Router();
require_once __DIR__ . '/../routes/web.php';

// Dispatch request
$router->dispatch();