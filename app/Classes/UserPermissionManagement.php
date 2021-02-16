<?php
namespace App\Classes;

use App\Events\AccountRegistered;
use App\Http\Resources\UserResource;
use App\Models\UserActivity;
use App\Repositories\Interfaces\UserPermissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ActivityManager;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserPermissionManagement {
    use ActivityManager;

    private $userPermissionRepository;

    public function __construct(
        UserPermissionRepositoryInterface $userPermissionRepository
    ) {
        $this->userPermissionRepository = $userPermissionRepository;
    }

    public function create(array $data): Response {
        $permissions = [];
        DB::transaction(function () use (&$permissions, $data){
            $permissions = $this->userPermissionRepository->create($data);
        });
        $message = "Permission granted.";
        return response()->created(
            $message,
            $permissions,
            'permissions'
        );
    }

    public function all(array $data): Response {
        $permissions = [];
        DB::transaction(function () use (&$permissions, $data){
            $permissions = $this->userPermissionRepository->all();
        });
        $message = "Permissions fetched.";
        return response()->created(
            $message,
            $permissions,
            'permissions'
        );
    }

    public function revoke(string $userPermissionId): Response {
        $permissions = [];
        DB::transaction(function () use (&$permissions, $userPermissionId){
            $permissions = $this->userPermissionRepository->revoke($userPermissionId);
        });
        $message = "Permission revoked.";
        return response()->deleted(
            $message,
            $permissions,
            'permissions'
        );
    }

    public function userPermissions(string $userId): Response {
        $permissions = $this->userPermissionRepository->userPermissions($userId);
        $message = "User permissions.";
        return response()->fetch(
            $message,
            $permissions,
            'permissions'
        );
    }
}
