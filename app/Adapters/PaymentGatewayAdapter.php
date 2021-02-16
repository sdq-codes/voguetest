<?php


namespace App\Adapters;


use App\Adapters\Interfaces\PaymentGatewayAdapterInterface;
use GuzzleHttp\Client;

class PaymentGatewayAdapter implements PaymentGatewayAdapterInterface
{
    protected $url;

    protected $authToken;

    protected $headers;

    protected $client;

    protected $body;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = env('PAYMENT_API_URL');
        $this->authToken = env('PAYMENT_API_TOKEN');
        $this->headers = [
            'Authorization' => "Bearer $this->authToken"
        ];

        $this->body = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];
    }

    private function initiateTransfer($data): array
    {
        $url = $this->url . '/transfer';
        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'form_params' => [
                "source" => "balance",
                "reason" => $data['money'],
                "amount" => $data['amount'],
                "recipient" => $data['recipient']
            ]
        ]);

        return json_decode($response->getBody());
    }

    public function transfer($data): array
    {
        $url = $this->url . '/finalize_transfer';
        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'form_params' => [
                "transfer_code" => $this->initiateTransfer($data)->data->transfer_code,
                "otp" => $data['otp']
            ]
        ]);

        return json_decode($response->getBody());
    }

}
