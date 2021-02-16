<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::updateOrCreate(['name' => 'create-user'], [
            "name" => 'create-user',
            "active" => 1
        ]);
        Permission::updateOrCreate(['name' => 'create-user-permission'], [
            "name" => 'create-user-permission',
            "active" => 1
        ]);
        Permission::updateOrCreate(['name' => 'revoke-user-permission'], [
            "name" => 'revoke-user-permission',
            "active" => 1
        ]);
        Permission::updateOrCreate(['name' => 'money-transfer-permission'], [
            "name" => 'money-transfer-permission',
            "active" => 1
        ]);
    }
}
