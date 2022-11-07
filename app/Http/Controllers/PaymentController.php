<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //






    public function makePayment(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;

        //Get checkbox array from post
        $payments = $_POST["payment"];
        $payAmount = 0;


        for ($i = 0; $i < count($payments); $i++) {
            //get unpaid payment amount from database 
            $unpaidPaymentsAmount = DB::table('payments')
                ->where('payment_id', $payments[$i])
                ->select('amount', 'renting_id')
                ->get();

            $payAmount += $unpaidPaymentsAmount[0]->amount;
        }
        $payAmount = 1.00;

        //Put payment id array session
        $request->session()->put('payments', $payments);

        //link to paypal
        // return view('paypal/paypalpage', [
        //     'payAmount' => $payAmount,
        //     'renting_id' => $unpaidPaymentsAmount[0]->renting_id
        // ]);

        return redirect(URL('/dashboard/payment/paymentSuccess')); //for testing

    }

    public function paymentSuccess(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;


        //Get payment id array from session
        if (session()->has('payments')) {
            $payments = $request->session()->get('payments');
            session()->forget('payments');
        }

        $payAmount = 0;

        for ($i = 0; $i < count($payments); $i++) {

            //get update payments details in database 
            // $updated = DB::table('payments')
            //     ->where('payment_id', $payments[$i])
            //     ->update(['status' => 'paid', 'paid_date' => date("Y-m-d")]);

            //get unpaid payment amount from database 
            $unpaidPaymentsAmount = DB::table('payments')
                ->where('payment_id', $payments[$i])
                ->select('amount', 'renting_id')
                ->get();

            $payAmount += $unpaidPaymentsAmount[0]->amount;
        }
        $payAmount = 1.00;

dd("stop here");

    }
}
