<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Transaction
    {
        return $this->model->create($data);
    }

    public function all(): Collection {
        return $this->model::all();
    }

    public function user(string $userId): Collection {
        return $this->model->where('user_id', $userId)->get();
    }
}
