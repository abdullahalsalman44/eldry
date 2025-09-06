<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\services\MyFatoorahService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Donations\CreateDonationRequest;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    use ResponseTrait;

    protected MyFatoorahService $myFatoorah;
    public function __construct(MyFatoorahService $myFatoorah)
    {
        $this->myFatoorah = $myFatoorah;
    }

    public function store(CreateDonationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['NotificationOption'] = 'All';
            $data['Language'] = App::getLocale();
            $data['DisplayCurrencyIso'] = 'kwd';
            $data['CallBackUrl'] = route('donation.callback');
            $payment =  $this->myFatoorah->sedPayment($data);

            DB::commit();

            return $this->successResponse(json_decode($payment));
        } catch (\Throwable $e) {
            Log::info($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            return $this->errorResponse($e->getMessage(), code: 500);
        }
    }

    public function success(Request $request)
    {
        try {
            $paymentId = $request->query('paymentId');

            $payment = $this->myFatoorah->getPaymentInfo($paymentId);

            if ($payment['IsSuccess'] && $payment['Data']['InvoiceStatus'] === 'Paid') {
                $data = $payment['Data'];

                Donation::query()->create([
                    'donor_name' => $data['CustomerName'],
                    'donor_email' => $data['CustomerEmail'],
                    'donor_phone' => $data['CustomerMobile'],
                    'invoice_id'  => $payment['Data']['InvoiceId'],
                    'amount' => $data['InvoiceValue'],
                    'payment_method' => 'MyFatoorah',
                ]);
                return $this->successResponse($data, 'Donation stored successfully');
            }
            return $this->successResponse($payment);
        } catch (\Throwable $e) {
            Log::info($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            return $this->errorResponse($e->getMessage(), code: 500);
        }
    }
}
