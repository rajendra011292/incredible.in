<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\JournalService;

class JournalController extends Controller {
    private JournalService $journalService;

    public function __construct() {
        $this->journalService = new JournalService();
    }

    public function index(): void {
        $this->requireAuth();
        $entries = $this->journalService->getAllForUser(Session::getUserId());
        $stats = $this->journalService->getStats(Session::getUserId());
        $this->view('journal/index', [
            'entries' => $entries,
            'stats' => $stats
        ]);
    }

    public function show(int $id): void {
        $this->requireAuth();
        $entry = $this->journalService->getById($id, Session::getUserId());
        
        if (!$entry) {
            Session::setFlash('error', 'Journal entry not found');
            $this->redirect('/journal');
        }

        $this->view('journal/show', ['entry' => $entry]);
    }
}