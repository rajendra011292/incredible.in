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
        
        $userId = Session::getUserId();
        if (!$userId) {
            Session::setFlash('error', 'User authentication error. Please log in again.');
            $this->redirect('/login');
            return;
        }
        
        $setups = $this->setupService->getAllForUser($userId);
        $this->view('setups/index', ['setups' => $setups]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->view('setups/create');
    }

    public function store(): void {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        if (!$userId) {
            Session::setFlash('error', 'User authentication error. Please log in again.');
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'user_id' => $userId,
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
        
        $userId = Session::getUserId();
        if (!$userId) {
            Session::setFlash('error', 'User authentication error. Please log in again.');
            $this->redirect('/login');
            return;
        }
        
        $setup = $this->setupService->getById($id, $userId);
        
        if (!$setup) {
            Session::setFlash('error', 'Setup not found');
            $this->redirect('/setups');
        }

        $this->view('setups/edit', ['setup' => $setup]);
    }

    public function update(int $id): void {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        if (!$userId) {
            Session::setFlash('error', 'User authentication error. Please log in again.');
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'strategy' => $_POST['strategy'] ?? ''
        ];

        $this->setupService->update($id, $userId, $data);
        Session::setFlash('success', 'Setup updated successfully');
        $this->redirect('/setups');
    }

    public function delete(int $id): void {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        if (!$userId) {
            Session::setFlash('error', 'User authentication error. Please log in again.');
            $this->redirect('/login');
            return;
        }
        
        $this->setupService->delete($id, $userId);
        Session::setFlash('success', 'Setup deleted successfully');
        $this->redirect('/setups');
    }
}