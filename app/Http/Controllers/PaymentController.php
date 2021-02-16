<?php

namespace App\Http\Controllers;

use App\Classes\PaymentManagement;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $paymentManagement;
    public function __construct(PaymentManagement $paymentManagement)
    {
        //
        $this->paymentManagement = $paymentManagement;
    }

    public function create(Request $request) {
        return $this->paymentManagement->create($request->all());
    }

    public function all() {
        return $this->paymentManagement->all();
    }

    public function user($userId) {
        return $this->paymentManagement->users($userId);
    }

    //
}
