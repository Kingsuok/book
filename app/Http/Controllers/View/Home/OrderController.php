<?php

namespace App\Http\Controllers\View\Home;

use App\Http\Models\CartItem;
use App\Http\Models\Order;
use App\Http\Models\OrderItem;
use App\Http\Models\Product;
use App\Tools\UUID;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use function MongoDB\BSON\toJSON;

class OrderController extends CommonController
{
    // deal oder commit
    public function orderCommit(Request $request)
    {
        $member = $request->session()->get('member','');
        $productIds = $request->input('productIds','');
        $productIds = $productIds != ''? explode(',',$productIds):array();
        $cartItems = CartItem::where('member_id',$member->id)->whereIn('product_id',$productIds)->get();
        if ($cartItems->isEmpty()){
            return redirect()->back();
        }
        //return $cartItems;//测试用
        $cartItemArray = array();
        $sum = 0;// total price
        $name = '';// order name
        $order = new Order();
        $order->order_no = 'E'.time().UUID::create();
        $order->member_id = $member->id;
        // 这里是为了事先获得order_id, 因为order_item需要用到order_id，
        //如果不提前save，下面就要在使用一个for循环来存储 order item
        $order->save();
        $orderId = $order->id;

        foreach ($cartItems as $cartItem) {
            $cartItem->product = Product::where('id',$cartItem->product_id)->first();
            if ($cartItem->product != null){// 防止商品被误修改，误删除,所以判断一下是否为null
                array_push($cartItemArray,$cartItem);
                $sum += $cartItem->count * $cartItem->product->price;
                $name .= '< '. $cartItem->product->product_name . ' >';
                // store the order item
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product->id;
                $orderItem->count = $cartItem->count;
                $orderItem->product_snapshot = json_encode($cartItem->product);
                $orderItem->save();
            }
        }
        $sum = number_format($sum,2);//保留两位小数
        // order no: E + timestamp + UUID
        $order->total_price = $sum;
        $order->name = $name;
        $order->save();
        // after submitted the order, delete the product in cart
        CartItem::where('member_id',$member->id)->whereIn('product_id',$productIds)->delete();

        return view('home.orderCommit',compact('cartItemArray','sum','orderId'));
    }

    //deal with order list
    public function orderList(Request $request)
    {
        $member = $request->session()->get('member','');
        $orders = Order::where('member_id',$member->id)->orderBy('id','desc')->get();
        foreach ($orders as $order) {
            $orderItems = OrderItem::where('order_id',$order->id)->get();
            $order->orderItems = $orderItems;
            foreach ($orderItems as $orderItem) {
                // 使用快照获取商品信息
                $product = json_decode($orderItem->product_snapshot);
                $orderItem->product = $product;
            }
        }
        return view('home.orderList',compact('orders'));
    }

    // pay an order directly
    public function payOrder(Request $request)
    {
        $orderId = $request->input('orderId','');
        $order = Order::where('id',$orderId)->first();
        if ($order != null && $order->status == 1){
            return view('home.payOrderCard',compact('order'));
        }

    }

}
