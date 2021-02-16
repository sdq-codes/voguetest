<?php
namespace App\Repositories;

use App\Models\UserPermission;
use App\Repositories\Interfaces\UserPermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserPermissionRepository extends BaseRepository implements UserPermissionRepositoryInterface {
    public function __construct(UserPermission $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Collection
    {
        $this->model->create($data);
        return $this->userPermissions($data['user_id']);
    }

    public function revoke(string $userPermissionId): Collection
    {
        $userPermission = $this->model->find($userPermissionId);
        $this->model->where('id', $userPermissionId)->delete();
        return $this->userPermissions($userPermission->user_id);
    }

    public function userPermissions(string $userId): Collection
    {
        return $this->model
            ->with('permission')
            ->where('user_id', $userId)
            ->get();
    }

    public function all(): Collection
    {
        return $this->model
            ->with('permission')
            ->get();
    }
}
