<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): User
    {
        return $this->model->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'user_type' => $data['user_type']
        ]);
    }

}
