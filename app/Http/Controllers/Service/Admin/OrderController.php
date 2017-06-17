<?php

namespace App\Http\Controllers\Service\Admin;

use App\Http\Models\Order;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // delete a order
    public function deleteOrder(Request $request)
    {
        $m3Result = new M3Result();
        $id = $request->input('id','');
        if ($id == ''){
            $m3Result->status = 1;
            $m3Result->message = 'id should not be empty';
        }else{
            Order::where('id', $id)->delete();
            $m3Result->status = 0;
            $m3Result->message = 'delete successfully';
        }
        return $m3Result->toJson();
    }
    // update a order
    public function updateOrder(Request $request)
    {
        $m3Restult = new M3Result();
        $id = $request->input('id','');
        $status = $request->input('status','');
        if ($id == ''){
            $m3Restult->status = 1;
            $m3Restult->message = 'id should not be empty';
        }else{
            $order = Order::where('id',$id)->first();
            if ($order == null){
                $m3Restult->status = 1;
                $m3Restult->message = 'id should not be empty';
            }else{
                switch ($status){
                    case '1' :
                        $order->status = 1;
                        $order->delivery = 1;
                        $order->received = 1;
                        break;
                    case '2' :
                        $order->status = 0;
                        $order->delivery = 1;
                        $order->received = 1;
                        break;
                    case '3':
                        $order->status = 0;
                        $order->delivery = 0;
                        $order->received = 1;
                        break;
                    case '4':
                        $order->status = 0;
                        $order->delivery = 0;
                        $order->received = 0;
                        break;
                }

                $order->save();
                $m3Restult->status = 0;
                $m3Restult->message = 'edit successfully';
            }
        }
        return $m3Restult->toJson();
    }
}
