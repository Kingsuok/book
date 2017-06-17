<?php

namespace App\Http\Controllers\View\Admin;
use App\Http\Models\Category;
use App\Http\Models\PdtContent;
use App\Http\Models\PdtImages;
use App\Http\Models\Product;
use Log;
use Symfony\Component\Debug\Tests\Fixtures\ClassAlias;

class ProductController extends CommonController
{
    //GET, admin/product, all category list
    public function index()
    {
        $products = Product::orderBy('id','desc')->paginate(8);
        foreach ($products as $product){
            $category = Category::where('id',$product->category_id)->first();
            $product->category = $category;
        }
        return view('admin.productIndex',compact('products'));
    }
    //GET, admin/product/{product}, show a single product
    public function show($id)
    {
        // get the product info
        $product = Product::where('id',$id)->first();
        $content = PdtContent::where('product_id',$id)->first();
        $images = PdtImages::where('product_id',$id)->get();
        $category = Category::where('id', $product->category_id)->first();
        $product->category = $category;
        return view('admin.productDetail',compact('product','content','images'));
    }
    //GET, admin/product/create, add a new product
    public function create()
    {
        $categorys = Category::where('parent_id','!=',0)->get();
        return view('admin.productAdd',compact('categorys'));
    }
    //POST, admin/product. store the added new product
    public function store()
    {

    }
    //GET, admin/product/{product}/edit, edit a product
    public function edit($id)
    {
        // get the product info
        $product = Product::where('id',$id)->first();
        $content = PdtContent::where('product_id',$id)->first();
        $product->content = $content;
        $images = PdtImages::where('product_id',$id)->get();
        $images = $images->toArray();
        $product->images = $images;
        $categorys = Category::where('parent_id','<>',0)->get();

        return view('admin.productEdit',compact('product','categorys'));
    }
    //PUT, admin/product/{product}, update a product
    public function update($id)
    {

    }
    //DELETE, admin/product/{product}, delete a  product
    public function destroy($id)
    {

    }
}
