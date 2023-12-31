<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Omnipay\Common\ServiceProvider;

use Omnipay\Omnipay;


class PaypalController extends Controller
{
    private $gateway;

    public function __construct(){
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientID(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }


    public function paypal(){
        if(Session::has('order_id')){
          return view('front.paypal.paypal');
        }else{
            return redirect('cart');
        }

    }
public function pay(Request $request){
    try{

        $paypal_amount=round(Session::get('grand_total')/80,2);
        //echo $paypal_amount;
        $response= $this->gateway->purchase(array(
            'amount' => $paypal_amount,
            'currency' => env('PAYPAL_CURRENCY'),
            'returnUrl' => url('success'),
            'cancelUrl' => url('error')
        ))->send();
        if($response->isRedirect()){
            $response->redirect();
        }else{
            return $response->getMessage();
        }
    }catch(\Throwable $th)
    {
        return $th->getMessage();
    }
}
public function success(Request $request){
    if($request->input('paymentId') && $request->input('PayerID')){
        $transaction=$this->gateway->completePurchase(array(
            'payer_id'=>$request->input('PayerID'),
            'transactionReference' => $request->input('PaymentId')

        ));
        $response=$transaction->send();
        if($response->isSuccessful()){
            $arr=$response->getData();
            $payment=new Payment;
$payment->order_id=Session::get('order_id');
$payment->user_id=Auth::user()->id;
$payment->payment_id=$arr['id'];
$payment->payer_id=$arr['payer']['payer_info']['payer_id'];
$payment->payer_email=$arr['payer']['payer_info']['email'];
$payment->amount=$arr['transactions'][0]['amount']['total'];
$payment->currency=env('PAYPAL_CURRENCY');
$payment->payment_status=$arr['state'];
$payment->save();
return "Payment is Successful. Your Transaction is:- ". $arr['id'];
        }
        else{
            return $response->getMessage();
        }





    }else{
        return "Payment Declined";
    }

}


public function error(){
    return "User declined the Payment";
}
}