<?php

namespace App\Http\Controllers\View\Admin;
use App\Http\Models\Order;
use App\Http\Models\OrderItem;
use App\Http\Models\Product;
use Log;

class OrderController extends CommonController
{
    //GET, admin/order, all order list
    public function index()
    {
        $orders = Order::orderBy('id','desc')->paginate(8);

        return view('admin.orderIndex',compact('orders'));
    }
    //GET, admin/order/{order}, show a single order
    public function show($id)
    {
         $orderItems = OrderItem::where('order_id', $id)->get();
         $count = 0;
         foreach ($orderItems as $orderItem){
             $product = Product::select('product_name','price')->where('id',$orderItem->product_id)->first();
             $orderItem->product = $product;
         }
         $orderNo = Order::select('order_no')->where('id',$id)->first();
         return view('admin.orderItems',compact('orderItems','id','orderNo','count'));
    }
    //GET, admin/order/create, add a new order
    public function create()
    {
    }
    //POST, admin/order. store the added new order
    public function store()
    {

    }
    //GET, admin/order/{order}/edit, edit a order
    public function edit($id)
    {
        $order = Order::where('id',$id)->first();
        return view('admin.orderEdit',compact('order'));

    }
    //PUT, admin/order/{order}, update a order
    public function update($id)
    {

    }
    //DELETE, admin/order/{order}, delete a  order
    public function destroy($id)
    {

    }
}
