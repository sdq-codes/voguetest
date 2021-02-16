<?php
namespace App\Classes;

use App\Events\AccountRegistered;
use App\Http\Resources\UserResource;
use App\Models\UserActivity;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ActivityManager;
use Illuminate\Support\Facades\DB;

class UserManagement {
    use ActivityManager;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function createUser(&$user,$data) {
        $data['password'] = generateRandomString(36);
            $user = $this->userRepository->create($data);
            $this->activityLog(
                $user->id,
                "$user->name account has been created.",
                'register'
            );
    }

    public function create(array $data) {
        $user = null;
        DB::transaction(function () use (&$user, $data){
            $this->createUser($user, $data);
        });
        $resource = new UserResource($user);
        $message = "Account created.. An email has been sent to the new user.";
        return response()->created(
            $message,
            $resource,
            'user'
        );
    }
}
