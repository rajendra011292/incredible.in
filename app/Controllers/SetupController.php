<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\SetupService;

class SetupController extends Controller {
    private SetupService $setupService;

    public function __construct() {
        $this->setupService = new SetupService();
    }

    public function index(): void {
        $this->requireAuth();
        $setups = $this->setupService->getAllForUser(Session::getUserId());
        $this->view('setups/index', ['setups' => $setups]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->view('setups/create');
    }

    public function store(): void {
        $this->requireAuth();
        
        $data = [
            'user_id' => Session::getUserId(),
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'strategy' => $_POST['strategy'] ?? ''
        ];

        $this->setupService->create($data);
        Session::setFlash('success', 'Setup created successfully');
        $this->redirect('/setups');
    }

    public function edit(int $id): void {
        $this->requireAuth();
        $setup = $this->setupService->getById($id, Session::getUserId());
        
        if (!$setup) {
            Session::setFlash('error', 'Setup not found');
            $this->redirect('/setups');
        }

        $this->view('setups/edit', ['setup' => $setup]);
    }

    public function update(int $id): void {
        $this->requireAuth();
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'strategy' => $_POST['strategy'] ?? ''
        ];

        $this->setupService->update($id, Session::getUserId(), $data);
        Session::setFlash('success', 'Setup updated successfully');
        $this->redirect('/setups');
    }

    public function delete(int $id): void {
        $this->requireAuth();
        $this->setupService->delete($id, Session::getUserId());
        Session::setFlash('success', 'Setup deleted successfully');
        $this->redirect('/setups');
    }
}