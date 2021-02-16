<?php
namespace App\Repositories\Interfaces;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

interface TransactionRepositoryInterface {
    public function create(array $data): Transaction;

    public function all(): Collection;

    public function user(string $userId): Collection;
}
