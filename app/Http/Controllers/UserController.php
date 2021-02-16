<?php
namespace App\Http\Controllers;

use App\Classes\UserManagement;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    private $userManagement;

    public function __construct(UserManagement $userManagement) {
        $this->userManagement = $userManagement;
    }

    public function create(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'user_type' => 'required',
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
        ]);
        $this->authorize('create-user', User::class);
        return $this->userManagement->create($request->all());
    }
}
