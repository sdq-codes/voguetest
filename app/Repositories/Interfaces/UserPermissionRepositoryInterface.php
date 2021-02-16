<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserPermissionRepositoryInterface {
    public function create(array $data): Collection;

    public function revoke(string $userPermissionId): Collection;

    public function userPermissions(string $userId): Collection;

    public function all(): Collection;
}
