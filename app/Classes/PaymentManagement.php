<?php

namespace App\Classes;

use App\Adapters\Interfaces\PaymentGatewayAdapterInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class PaymentManagement
{

    protected $paymentGatewayAdapter;

    protected $transactionRepository;

    public function __construct(
        PaymentGatewayAdapterInterface $paymentGatewayAdapter,
        TransactionRepositoryInterface $transactionRepository

    )
    {
        $this->paymentGatewayAdapter = $paymentGatewayAdapter;
        $this->transactionRepository = $transactionRepository;
    }

    public function create(array $data) {
        $transfer = $this->paymentGatewayAdapter->transfer($data);
        DB::transaction(function () use (&$transfer, $data) {
            $transfer = $this->transactionRepository->create($data);
        });
        return response()->created(
            'transaction successful',
            $transfer,
            'transactions'
        );
    }

    public function all() {
        $transfers = $this->transactionRepository->all();
        return response()->created(
            'Transactions fetched',
            $transfers,
            'transactions'
        );
    }

    public function users(string $userId) {
        $transfers = $this->transactionRepository->user($userId);
        return response()->created(
            'User transactions fetched',
            $transfers,
            'transactions'
        );
    }
}
