<?php

namespace App\Http\Controllers\Service\Home;
use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use Illuminate\Http\Request;
use Log;

class PayController extends Controller
{
    public function orderCharge(Request $request)
    {
        $orderNo = $request->input('orderNo','');
        $order = Order::where('order_no',$orderNo)->first();
        if ($order->status == 0){
            $status = 2;
            $message = 'Do not repeat payments!';
            return view('home.payOrderStatus')
                ->with('status',$status)
                ->with('message',$message);
        }

        $receiver = trim($request->input('name',''));
        $phone = trim($request->input('number',''));
        $address = trim($request->input('address',''));
        if($receiver == '' || $phone == '' || $address == ''){
            $status = 4;
            $message = 'receiver, phone, address should not be empty';
            return view('home.payOrderStatus')
                ->with('status',$status)
                ->with('message',$message);
        }elseif(!is_numeric($phone) || strlen($phone) != 10){
            $status = 5;
            $message = 'phone should be 10 digits';
            return view('home.payOrderStatus')
                ->with('status',$status)
                ->with('message',$message);
        }else{
            $order->delivery_receiver = $receiver;
            $order->delivery_phone = $phone;
            $order->delivery_address = $address;
            $order->save();
        }

        if ($orderNo == ''){
            $status = 1;
            $message = 'Order should not be empty. Please try again or contact us.';
            return view('home.payOrderStatus')
                ->with('status',$status)
                ->with('message',$message);
        }

        $member = $request->session()->get('member','');
        $stripeToken = $request->input('stripeToken','');

        $memberId = $member->id;
        $currency = $request->input('currency','');
        $amount = $request->input('amount','');
        $amount = $amount * 100; //amount 的单位是分，不是元，所以要
        $description = 'order paid';
        $detail = array(
            'orderNo'=>$orderNo,
            'memberId' => $memberId,
        );
        // must contain  contains the token, currency, amount to charge,
        // other info we can choose to add using metadata
        // metadata 是一个数组，用来存放自己想存的其他数据
        $orderInfo = array(
            'description' => $description,
            "amount" => $amount,// amount 的单位是分，不是元，所以要
            "currency" => $currency,
            "source" => $stripeToken,
            "metadata" => $detail,
        );
        return $this->charge($stripeToken,$orderInfo);
   }
   // order charge
   private function charge($stripeToken, $orderInfo){
       // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
       \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      // Token is created using Stripe.js or Checkout!
      // Get the payment token submitted by the form:
       $token = $stripeToken;

       // Charge the user's card:
       try{
           $charge = \Stripe\Charge::create($orderInfo);
       }catch(\Stripe\Error\Card $e) {
           Log::info('order ID: '.$orderInfo['orderNo'] . ' fail to pay ');
           // payment fail
           $status = 3;
           $message = 'Your credit card has some problem. Please try again or contact us.';
           return view('home.payOrderStatus')
               ->with('status',$status)
               ->with('message',$message);
       }

       // payment successful, then set order status to be 0: the order has been paid
       $order = Order::where('order_no',$orderInfo['metadata']['orderNo'])->first();
       $order->status = 0;
       $order->save();
       Log::info('order No: '.$orderInfo['metadata']['orderNo'] . ' paid successfully');
       $status = 0;
       $message = 'payment successfully';
       return view('home.payOrderStatus')
           ->with('status',$status)
           ->with('message',$message);
   }
}
