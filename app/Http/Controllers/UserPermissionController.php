<?php
namespace App\Http\Controllers;

use App\Classes\UserPermissionManagement;
use App\Models\User;
use App\Repositories\Interfaces\UserPermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPermissionController extends Controller {
    private $userPermissionManagement;

    public function __construct(UserPermissionManagement $userPermissionManagement)
    {
        $this->userPermissionManagement = $userPermissionManagement;
        Auth::shouldUse('api');
    }

    protected function uniquePermissions() {
    }

    public function create(Request $request) {
        $this->validate($request, [
            "user_id" => "required",
            "permission_id" => ["required"]
        ]);
        $this->authorize('create-user-permission', User::class);
        return $this->userPermissionManagement->create($request->all());
    }

    public function all() {
        $this->authorize('create-user-permission', User::class);
        return $this->userPermissionManagement->all();
    }

    public function revoke(string $userPermissionId) {
        $this->authorize('revoke-user-permission', User::class);
        return $this->userPermissionManagement->revoke($userPermissionId);
    }

    public function user(string $userId) {
        $this->authorize('create-user-permission', User::class);
        return $this->userPermissionManagement->userPermissions($userId);
    }
}
