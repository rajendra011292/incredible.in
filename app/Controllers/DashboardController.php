<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\SetupService;
use App\Services\PlanService;
use App\Services\PositionService;
use App\Services\JournalService;

class DashboardController extends Controller
{
    private SetupService $setupService;
    private PlanService $planService;
    private PositionService $positionService;
    private JournalService $journalService;

    public function __construct()
    {
        $this->setupService = new SetupService();
        $this->planService = new PlanService();
        $this->positionService = new PositionService();
        $this->journalService = new JournalService();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId = Session::getUserId();

        $data = [
            'username' => Session::get('username'),
            'setupCount' => count($this->setupService->getAllForUser($userId)),
            'pendingPlans' => $this->planService->getPendingCount($userId),
            'openPositions' => $this->positionService->getOpenPositions($userId),
            'stats' => $this->journalService->getStats($userId),
            'recentEntries' => $this->journalService->getRecent($userId, 5)
        ];




        $this->view('dashboard/index', $data);
    }
}
