<?php

namespace App\Http\Controllers\View\Home;

use App\Http\Models\CartItem;
use App\Http\Models\Category;
use App\Http\Models\PdtContent;
use App\Http\Models\PdtImages;
use App\Http\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

class IndexController extends CommonController
{
    public function index(Request $request)
    {
        //$cartItems = array();// store all the products in the cart, it will be an array
        $cart = $request->cookie('cart');
        $cartArray = $cart != null ? explode(',',$cart) : array();

        // deal with the member's cart
        $member = $request->session()->get('member','');
        if ($member != ''){
             $cartItems = CartItem::where('member_id',$member->id)->get();
            $cartCount = $cartItems->count();
        }else{
            $cartCount = count($cartArray);
        }
        $hots = Product::where('preview','!=','')->orderBy('hot','desc')->take(5)->get();
        $news = Product::where('preview','!=','')->orderBy('new','desc')->take(6)->get();
        return view('home.index',compact('hots','news','cartCount'));
   }

    //get the book's parent category
    public function category()
    {   // print log
        Log::info('welcome to book category!');

        $categorys = Category::where('parent_id',0)->get();
        return view('home.category',compact('categorys'));
    }

    //get the products
    public function product($categoryId)
    {
        $products = Product::where('category_id',$categoryId)->get();
        return view('home.product', compact('products'));
    }

    // get one product detail
    public function pdtDetail($pdtId, Request $request)
    {
        $product = Product::where('id',$pdtId)->first();
        $pdtContent = PdtContent::where('product_id',$pdtId)->first();
        $pdtImages = PdtImages::where('product_id',$pdtId)->get();

        //get the count of the pdtId
        $count  = 0;
        //处理member登录后的情况：cart 信息从database读取
        $member = $request->session()->get('member','');
        if ($member != ''){
            $cartItem = CartItem::where('member_id',$member->id)->where('product_id',$pdtId)->first();
            if ($cartItem != null){
                $count =  $cartItem->count;
            }
        }else{// 处理没有登录时，cart item 从cookie读取
            // get the cart number in cookie
            $cart = $request->cookie('cart');
            $cartArray = $cart != null ? explode(',',$cart) : array();

            foreach ($cartArray as $value){
                $index = strpos($value,':');
                $productId = substr($value,0,$index);
                if ($productId == $pdtId){
                    $count = (int)substr($value,$index+1);
                    break;
                }
            }
        }
        return view('home.pdtDetail',compact('product','pdtContent','pdtImages','count'));
    }
}
