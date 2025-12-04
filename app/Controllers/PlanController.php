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

    public function index(): void {
        $this->requireAuth();
        $plans = $this->planService->getAllForUser(Session::getUserId());
        $this->view('plans/index', ['plans' => $plans]);
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
            'direction' => $_POST['direction'] ?? 'long',
            'entry_price' => $_POST['entry_price'] ?? 0,
            'stop_loss' => $_POST['stop_loss'] ?? 0,
            'take_profit' => $_POST['take_profit'] ?? 0,
            'position_size' => $_POST['position_size'] ?? 0,
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
            'direction' => $_POST['direction'] ?? 'long',
            'entry_price' => $_POST['entry_price'] ?? 0,
            'stop_loss' => $_POST['stop_loss'] ?? 0,
            'take_profit' => $_POST['take_profit'] ?? 0,
            'position_size' => $_POST['position_size'] ?? 0,
            'notes' => $_POST['notes'] ?? ''
        ];

        $this->planService->update($id, Session::getUserId(), $data);
        Session::setFlash('success', 'Plan updated successfully');
        $this->redirect('/plans');
    }

    public function execute(int $id): void {
        $this->requireAuth();
        $result = $this->planService->execute($id, Session::getUserId());
        
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
}