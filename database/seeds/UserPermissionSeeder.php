<?php

use \Illuminate\Database\Seeder;
use App\Models\UserPermission;

class UserPermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $createUserPermissionId = \App\Models\Permission::where('name', 'create-user')->first()->id;
        $createUserPermissionsPermissionId = \App\Models\Permission::where('name', 'create-user-permission')->first()->id;
        $revokeUserPermissionPermission = \App\Models\Permission::where('name', 'revoke-user-permission')->first()->id;
        $transferMoneyPermissionPermission = \App\Models\Permission::where('name', 'money-transfer-permission')->first()->id;
        $userId = \App\Models\User::where('user_type', 'super_admin')->first()->id;
        UserPermission::updateOrCreate(
            [
                "permission_id" => $createUserPermissionId,
                "user_id" => $userId
            ],
            [
                "permission_id" => $createUserPermissionId,
                "user_id" => $userId
            ]
        );
        UserPermission::updateOrCreate(
            [
                "permission_id" => $createUserPermissionsPermissionId,
                "user_id" => $userId
            ],
            [
                "permission_id" => $createUserPermissionsPermissionId,
                "user_id" => $userId
            ]
        );
        UserPermission::updateOrCreate(
            [
                "permission_id" => $revokeUserPermissionPermission,
                "user_id" => $userId
            ],
            [
                "permission_id" => $revokeUserPermissionPermission,
                "user_id" => $userId
            ]
        );
        UserPermission::updateOrCreate(
            [
                "permission_id" => $transferMoneyPermissionPermission,
                "user_id" => $userId
            ],
            [
                "permission_id" => $transferMoneyPermissionPermission,
                "user_id" => $userId
            ]
        );
    }
}
