<?php

namespace App\Http\Controllers\Service\Home;

use App\Http\Models\CartItem;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //add to cart
    public function addCart($pdtId, Request $request)
    {
        $m3Result = new M3Result();
        $m3Result->status = 0;
        $m3Result->message = 'Add successfully';
        $member = $request->session()->get('member','');
        if ($member != ''){
            $cartItem = CartItem::where([['member_id',$member->id],['product_id',$pdtId]])->first();
            //$cartItem = CartItem::where('member_id',$member->id)->where('product_id',$pdtId)->first();
            if($cartItem == null){
                $cartItem = new CartItem();
                $cartItem->member_id = $member->id;
                $cartItem->product_id = $pdtId;
                $cartItem->count = 1;
            }else{
                $cartItem->count++;
            }
            $cartItem->save();// update database
            return $m3Result->toJson();
        }else{
            // get the cookie， data format: "1:5,2:1,4:8", 5 pdtId = 1; 1 pdtId = 2 ...
            $cart = $request->cookie('cart',null);
            $cartArray = $cart != null ? explode(',',$cart) : array();// 必须是 array
            // find the previous number of this pdtId
            $count = 1;
            foreach ($cartArray as &$value){// notice: 这里$value 前要加上取址符 & ，这样可以改变 $carArray
                $index = strpos($value, ':');// 找到 ：的位置
                $productId = substr($value,0, $index);
                if ($productId == $pdtId){
                    $count = (int)substr($value,$index + 1) + 1;
                    $value = $productId . ':' . $count;// update the count
                    break;
                }
            }
            // if this is the first time to add the pdtId
            if ($count == 1){
                array_push($cartArray,$pdtId . ':' . $count);
            }
            return response($m3Result->toJson())->withCookie('cart',implode(',',$cartArray));
        }
    }

    // delete the cart items
    public function deleteCart(Request $request)
    {
        $m3Result = new M3Result();
        $m3Result->status = 0;
        $m3Result->message = 'delete successfully';

        // get the items needed to be deleted
        $productIds = $request->input('productIds','');
        if ($productIds == ''){
            $m3Result->status = 1;
            $m3Result->message = "no item to be deleted";
            return $m3Result->toJson();
        }
        $productIdsArray = explode(',',$productIds);

        // deal with the member has login
        $member = $request->session()->get('member','');
        if ($member != '') {
            CartItem::where('member_id',$member->id)->whereIn('product_id',$productIdsArray)->delete();
            return $m3Result->toJson();
        }else{
            $cart = $request->cookie('cart',null);
            $cartArray = $cart != null ? explode(',',$cart) : array();// 必须是 array
            foreach ($cartArray as $key => $value ){
                $index = strpos($value,':');
                $productId = substr($value,0,$index);
                if (in_array($productId,$productIdsArray)){
                    array_splice($cartArray,$key);// 不能使用unset，unset删除后，元素index不变
                }
            }
            // notice to update cookie
            return response($m3Result->toJson())->withCookie('cart',implode(',',$cartArray));
        }
    }
}
