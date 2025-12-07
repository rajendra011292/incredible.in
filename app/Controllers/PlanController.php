<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\PlanService;
use App\Services\SetupService;

class PlanController extends Controller {
    private PlanService $planService;
    private SetupService $setupService;

    public function __construct() {
        $this->planService = new PlanService();
        $this->setupService = new SetupService();
    }

    public function index() {
        $this->requireAuth();
        $userId = Session::getUserId();
        if (!$userId) {
            // Redirect to login if user ID is not in session
            header('Location: /login');
            exit();
        }
        
        $plans = $this->planService->getAllForUser($userId);
        
        $this->view('plans/index', [
            'plans' => $plans,
            'success' => $_SESSION['success'] ?? null
        ]);
        
        unset($_SESSION['success']);
    }

    public function create(): void {
        $this->requireAuth();
        $setups = $this->setupService->getAllForUser(Session::getUserId());
        $this->view('plans/create', ['setups' => $setups]);
    }

    public function store(): void {
        $this->requireAuth();
        
        $data = [
            'user_id' => Session::getUserId(),
            'setup_id' => $_POST['setup_id'] ?? 0,
            'symbol' => strtoupper($_POST['symbol'] ?? ''),
            'sector' => $_POST['sector'] ?? null,
            'industry' => $_POST['industry'] ?? null,
            'direction' => $_POST['direction'] ?? 'long',
            'timeframe' => $_POST['timeframe'] ?? null,
            'entry_timeframe' => $_POST['entry_timeframe'] ?? null,
            'trend' => $_POST['trend'] ?? null,
            'emotion' => $_POST['emotion'] ?? null,
            'confidence' => $_POST['confidence'] ?? 0,
            'entry_price' => $_POST['entry_price'] ?? 0,
            'stop_loss' => $_POST['stop_loss'] ?? 0,
            'take_profit' => $_POST['take_profit'] ?? 0,
            'capital' => $_POST['capital'] ?? 0,
            'risk' => $_POST['risk'] ?? 0,
            'trade_date' => $_POST['trade_date'] ?? date('Y-m-d H:i:s'),
            'notes' => $_POST['notes'] ?? ''
        ];

        $this->planService->create($data);
        Session::setFlash('success', 'Plan created successfully');
        $this->redirect('/plans');
    }

    public function edit(int $id): void {
        $this->requireAuth();
        $plan = $this->planService->getById($id, Session::getUserId());
        
        if (!$plan || $plan['status'] !== 'pending') {
            Session::setFlash('error', 'Plan not found or cannot be edited');
            $this->redirect('/plans');
        }

        $setups = $this->setupService->getAllForUser(Session::getUserId());
        $this->view('plans/edit', ['plan' => $plan, 'setups' => $setups]);
    }

    public function update(int $id): void {
        $this->requireAuth();
        
        $data = [
            'setup_id' => $_POST['setup_id'] ?? 0,
            'symbol' => strtoupper($_POST['symbol'] ?? ''),
            'sector' => $_POST['sector'] ?? null,
            'industry' => $_POST['industry'] ?? null,
            'direction' => $_POST['direction'] ?? 'long',
            'timeframe' => $_POST['timeframe'] ?? null,
            'entry_timeframe' => $_POST['entry_timeframe'] ?? null,
            'trend' => $_POST['trend'] ?? null,
            'emotion' => $_POST['emotion'] ?? null,
            'confidence' => $_POST['confidence'] ?? 0,
            'entry_price' => $_POST['entry_price'] ?? 0,
            'stop_loss' => $_POST['stop_loss'] ?? 0,
            'take_profit' => $_POST['take_profit'] ?? 0,
            'capital' => $_POST['capital'] ?? 0,
            'risk' => $_POST['risk'] ?? 0,
            'notes' => $_POST['notes'] ?? ''
        ];

        $this->planService->update($id, Session::getUserId(), $data);
        Session::setFlash('success', 'Plan updated successfully');
        $this->redirect('/plans');
    }

    public function execute(int $id): void {
        $this->requireAuth();
        $userId = Session::getUserId();
        $plan = $this->planService->getById($id, $userId);
        
        if (!$plan || $plan['status'] !== 'pending') {
            Session::setFlash('error', 'Plan not found or cannot be executed');
            $this->redirect('/plans');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $setups = $this->setupService->getAllForUser($userId);
            $this->view('plans/execute', ['plan' => $plan, 'setups' => $setups]);
            return;
        }
        
        $result = $this->planService->execute($id, $userId);
        
        if ($result['success']) {
            Session::setFlash('success', 'Plan executed! Position opened.');
            $this->redirect('/positions/' . $result['position_id']);
        } else {
            Session::setFlash('error', $result['message']);
            $this->redirect('/plans');
        }
    }

    public function cancel(int $id): void {
        $this->requireAuth();
        $this->planService->cancel($id, Session::getUserId());
        Session::setFlash('success', 'Plan cancelled');
        $this->redirect('/plans');
    }

    public function show(int $id): void {
        $this->requireAuth();
        $userId = Session::getUserId();
        
        // Get the plan by ID and ensure it belongs to the current user
        $plan = $this->planService->getById($id, $userId);
        
        if (!$plan) {
            Session::setFlash('error', 'Plan not found or access denied');
            $this->redirect('/plans');
            return;
        }
        
        // Get related setup information if needed
        $setup = null;
        if (!empty($plan['setup_id'])) {
            $setup = $this->setupService->getById($plan['setup_id'], $userId);
        }
        
        // Render the view with plan and setup data
        $this->view('plans/show', [
            'plan' => $plan,
            'setup' => $setup,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        
        // Clear flash messages after displaying
        unset($_SESSION['success'], $_SESSION['error']);
    }
}