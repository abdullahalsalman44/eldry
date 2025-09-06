<?php

namespace App\services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MyFatoorahService
{
    protected $myFtoorahUrl;
    protected $token;
    public function __construct()
    {
        $this->myFtoorahUrl = config('services.myfatoorah.base_url');
        $this->token = config('services.myfatoorah.token');
    }
    public function sedPayment($data)
    {
        $payment = Http::withToken($this->token)
            ->post($this->myFtoorahUrl . '/v2/SendPayment', $data);
        return $payment;
    }

    public function getPaymentInfo($invoiceId)
    {
        $reponse = Http::withToken($this->token)
            ->post($this->myFtoorahUrl . '/v2/GetPaymentStatus', [
                'Key' => $invoiceId,
                'KeyType' => 'PaymentId',
            ]);

        $data = $reponse->json();

        return $data;
    }
}
