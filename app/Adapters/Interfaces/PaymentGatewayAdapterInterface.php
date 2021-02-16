<?php

namespace App\Adapters\Interfaces;

interface PaymentGatewayAdapterInterface {
    public function transfer($data): array;
}
