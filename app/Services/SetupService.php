<?php

namespace App\Services;

use App\Models\Setup;

class SetupService {
    private Setup $setupModel;

    public function __construct() {
        $this->setupModel = new Setup();
    }

    public function getAllForUser(int $userId): array {
        return $this->setupModel->findAllByUser($userId);
    }

    public function getById(int $id, int $userId): ?array {
        return $this->setupModel->findById($id, $userId);
    }

    public function create(array $data): int {
        return $this->setupModel->create($data);
    }

    public function update(int $id, int $userId, array $data): bool {
        return $this->setupModel->update($id, $userId, $data);
    }

    public function delete(int $id, int $userId): bool {
        return $this->setupModel->delete($id, $userId);
    }
}