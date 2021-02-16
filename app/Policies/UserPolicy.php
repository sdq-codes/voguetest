<?php
namespace App\Policies;

use App\Models\User;

class UserPolicy {
    public function createUser($user) {
        return count(User::with("userPermission")
                ->where('id', $user->id)
                ->whereHas("userPermission", function ($query) {
                    $query->with("permission")
                        ->whereHas("permission", function ($query) {
                            $query->where("name", "create-user");
                        });
                })
                ->get()
                ->toArray()) > 0;
    }

    public function createUserPermission($user) {
        return count(User::with("userPermission")
                ->where('id', $user->id)
                ->whereHas("userPermission", function ($query) {
                    $query->with("permission")
                        ->whereHas("permission", function ($query) {
                            $query->where("name", "create-user-permission");
                        });
                })
                ->get()
                ->toArray()) > 0;
    }
    public function revokeUserPermission($user) {
        return count(User::with("userPermission")
                ->where('id', $user->id)
                ->whereHas("userPermission", function ($query) {
                    $query->with("permission")
                        ->whereHas("permission", function ($query) {
                            $query->where("name", "revoke-user-permission");
                        });
                })
                ->get()
                ->toArray()) > 0;
    }
}
