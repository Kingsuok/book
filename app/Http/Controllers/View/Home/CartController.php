<?php

namespace App\Http\Controllers\View\Home;

use App\Http\Models\CartItem;
use App\Http\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

class CartController extends CommonController
{
    // get the  all the products in the cart
    public function cart(Request $request)
    {

        $cartItems = array();// store all the products in the cart, it will be an array
        $cart = $request->cookie('cart');
        $cartArray = $cart != null ? explode(',',$cart) : array();

        // deal with the member's cart
        $member = $request->session()->get('member','');
        if ($member != ''){
            $cartItems = $this->syncCart($cartArray,$member->id);

            //注意：下面的把 cookie置为null，很重要，
            //因为当member退出后，cookie中还有购物车信息，别人可以看到你买的东西
            return view('home.cart',compact('cartItems'))->withCookie('cart',null);
        }
        //对于没有登录的用户，$carArray 是从cookie中读出的，
        // 对于登录的用户，$carArray 是从数据库中读出的并和cookie进行比较同步后在显示到cart界面
        foreach ($cartArray as $key => $value){
            $index = strpos($value,':');
            //$carItem也可以用下面的数组方法 $carItem = array()；因为后面还要进行
            //只不过就是在view中一个是数组一个是对象，取值方式不一样，一个用 [],一个用 ->
            $carItem = new CartItem();
            // 对于没有登录的用户，因为$carArray 不是数据库信息，且不用操作数据库，所以$carItem->id没有影响
            //对于登录的用户，因为$arArray 是从数据库读出的信息，所以$key就是cart_itme的id
            //$carItem->id = $key;
            $carItem->product_id = substr($value, 0, $index);
            $carItem->count = (int) substr($value, $index+1);
            $carItem->product = Product::select('product_name','preview', 'price')->find($carItem->product_id);
            if($carItem->product != null) {
                array_push($cartItems, $carItem);
            }

//            $carItem = array();//
//            $carItem['product_id'] = substr($value,0,$index);
//            $carItem['count'] = (int)substr($value,$index + 1);
//            $carItem['product'] = Product::select('product_name','preview')->find($carItem['product_id']);
//            if ($carItem['product'] != null){
//                array_push($cartItems,$carItem);
//            }
        }
        return view('home.cart',compact('cartItems'));
    }

    // sync the cart between the cookie and the data in database
    private function syncCart($cartArray, $memberId){
        $cartItems = array();// store the cartItems finally
        $cartItemsDatabase = CartItem::where('member_id',$memberId)->get();
        if (!empty($cartArray)){
            foreach ($cartArray as $key => $value){
                $index = strpos($value,':');
                $productId = substr($value,0,$index);
                $count = substr($value,$index+1);
                $contain = false;// flag: 是否数据库中的cart中的商品和购物车cookie中同一产品
                foreach ($cartItemsDatabase as $cartItem) {
                    // 如果数据库中的cart中的商品和购物车cookie中同一产品，则产品数量要以cookie中的一致
                    if ($cartItem->product_id == $productId){
                        $cartItem->count = $count;
                        $cartItem->save();// update the cartItem
                        $cartItem->product = Product::where('id',$productId)->first();
                        array_push($cartItems,$cartItem);//放到结果中
                        $contain = true;
                    }
                    break;
                }
                // 如果cookie中的是新的商品，则新商品添加到数据库
                if ($contain == false){
                    $cartItem = new CartItem();
                    $cartItem->member_id = $memberId;
                    $cartItem->product_id = $productId;
                    $cartItem->count = $count;
                    $cartItem->save();// 新的商品保存到数据库
                    $cartItem->product = Product::where('id',$productId)->first();
                    array_push($cartItems,$cartItem);//放入结果中
                }
            }
        }else{
            foreach ($cartItemsDatabase as $cartItem) {
                $cartItem->product = Product::where('id', $cartItem->product_id)->first();
            }
            $cartItems = $cartItemsDatabase;
        }
        return $cartItems;
    }
}
