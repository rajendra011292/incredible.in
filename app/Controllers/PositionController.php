<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\PositionService;

class PositionController extends Controller {
    private PositionService $positionService;

    public function __construct() {
        $this->positionService = new PositionService();
    }

    public function index(): void {
        $this->requireAuth();
        $positions = $this->positionService->getAllForUser(Session::getUserId());
        $this->view('positions/index', ['positions' => $positions]);
    }

    public function show(int $id): void {
        $this->requireAuth();
        $position = $this->positionService->getById($id, Session::getUserId());
        
        if (!$position) {
            Session::setFlash('error', 'Position not found');
            $this->redirect('/positions');
        }

        $journalEntries = $this->positionService->getJournalEntries($id);
        $this->view('positions/show', [
            'position' => $position,
            'entries' => $journalEntries
        ]);
    }

    public function close(int $id): void {
        $this->requireAuth();
        
        $closePrice = $_POST['close_price'] ?? 0;
        $notes = $_POST['notes'] ?? '';
        
        $result = $this->positionService->closeFull($id, Session::getUserId(), $closePrice, $notes);
        
        if ($result['success']) {
            Session::setFlash('success', 'Position closed successfully. P&L: $' . number_format($result['pnl'], 2));
            $this->redirect('/positions/' . $id);
        } else {
            Session::setFlash('error', $result['message']);
            $this->redirect('/positions/' . $id);
        }
    }

    public function partialClose(int $id): void {
        $this->requireAuth();
        
        $closeSize = $_POST['close_size'] ?? 0;
        $closePrice = $_POST['close_price'] ?? 0;
        $notes = $_POST['notes'] ?? '';
        
        $result = $this->positionService->closePartial($id, Session::getUserId(), $closeSize, $closePrice, $notes);
        
        if ($result['success']) {
            Session::setFlash('success', 'Partial close successful. P&L: $' . number_format($result['pnl'], 2));
            $this->redirect('/positions/' . $id);
        } else {
            Session::setFlash('error', $result['message']);
            $this->redirect('/positions/' . $id);
        }
    }
}