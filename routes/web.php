<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\SetupController;
use App\Controllers\PlanController;
use App\Controllers\PositionController;
use App\Controllers\JournalController;

// Authentication routes
$router->get('/', [AuthController::class, 'showLogin']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard
$router->get('/dashboard', [DashboardController::class, 'index']);

// Setups
$router->get('/setups', [SetupController::class, 'index']);
$router->get('/setups/create', [SetupController::class, 'create']);
$router->post('/setups', [SetupController::class, 'store']);
$router->get('/setups/{id}/edit', [SetupController::class, 'edit']);
$router->post('/setups/{id}/update', [SetupController::class, 'update']);
$router->post('/setups/{id}/delete', [SetupController::class, 'delete']);

// Plans
$router->get('/plans', [PlanController::class, 'index']);
$router->get('/plans/create', [PlanController::class, 'create']);
$router->post('/plans', [PlanController::class, 'store']);
$router->get('/plans/{id}', [PlanController::class, 'show']);
$router->get('/plans/{id}/edit', [PlanController::class, 'edit']);
$router->post('/plans/{id}/update', [PlanController::class, 'update']);
$router->post('/plans/{id}/execute', [PlanController::class, 'execute']);
$router->post('/plans/{id}/cancel', [PlanController::class, 'cancel']);

// Positions
$router->get('/positions', [PositionController::class, 'index']);
$router->get('/positions/{id}', [PositionController::class, 'show']);
$router->post('/positions/{id}/close', [PositionController::class, 'close']);
$router->post('/positions/{id}/partial-close', [PositionController::class, 'partialClose']);

// Journal
$router->get('/journal', [JournalController::class, 'index']);
$router->get('/journal/{id}', [JournalController::class, 'show']);