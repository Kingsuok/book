<?php

namespace App\Http\Controllers\Service\Admin;


use App\Http\Models\Category;
use App\Http\Models\PdtContent;
use App\Http\Models\PdtImages;
use App\Http\Models\Product;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{  // store the new product
    public function storeProduct(Request $request)
    {
        $m3Restult = new M3Result();
        $name = trim($request->input('name',''));
        $brief = trim($request->input('brief',''));
        $price = trim($request->input('price',''));
        $categoryId = trim($request->input('categoryId',''));
        $new = trim($request->input('new',''));
        $hot = trim($request->input('hot',''));
        $preview = trim($request->input('preview',''));
        $content = trim($request->input('content',''));
        $image1 = trim($request->input('image1',''));
        $image2 = trim($request->input('image2',''));
        $image3 = trim($request->input('image3',''));
        $image4 = trim($request->input('image4',''));
        $image5 = trim($request->input('image5',''));
        $images = array($image1,$image2,$image3,$image4,$image5);
        // judge the input
        if ($name == ''|| $brief == '' || $price == ''){
            $m3Restult->status = 1;
            $m3Restult->message = 'name, brief, price should not be empty';
            return $m3Restult->toJson();
        }
        if(!preg_match("/[\d]*.?[\d]*/",$price)) {
            $m3Restult->status = 2;
            $m3Restult->message = 'price should be number';
            return $m3Restult->toJson();
        }
        // whether the category id is sub category
        $category = Category::where('parent_id','!=',0)->where('id',$categoryId)->first();
        if ($category == null){
            $m3Restult->status = 3;
            $m3Restult->message = 'no such category';
            return $m3Restult->toJson();
        }
        // store the data in to database
        $product = new Product();
        $product->product_name = $name;
        $product->summary = $brief;
        $product->preview = $preview;
        $product->price = $price;
        $product->category_id = $categoryId;
        $product->new = $new;
        $product->hot = $hot;
        $product->save();

        $pdtContent = new PdtContent();
        $pdtContent->product_id = $product->id;
        $pdtContent->content = $content;
        $pdtContent->save();

        foreach ($images as $image) {
            if ($image != ''){
                $pdtImage = new PdtImages();
                $pdtImage->image_path = $image;
                $pdtImage->product_id = $product->id;
                $pdtImage->save();
            }
        }
        $m3Restult->status = 0;
        $m3Restult->message = 'add product successfully';
        return $m3Restult->toJson();
    }

    // delete a product
    public function deleteProduct(Request $request)
    {
        $m3Result = new M3Result();
        $id = $request->input('id','');
        if ($id == ''){
            $m3Result->status = 1;
            $m3Result->message = 'id should not be empty';
        }else{
            Product::where('id', $id)->delete();
            $m3Result->status = 0;
            $m3Result->message = 'delete successfully';
        }
        return $m3Result->toJson();
    }
    // update a product
    public function updateProduct(Request $request)
    {
        $m3Restult = new M3Result();
        $id = trim($request->input('id',''));
        $name = trim($request->input('name',''));
        $brief = trim($request->input('brief',''));
        $price = trim($request->input('price',''));
        $categoryId = trim($request->input('categoryId',''));
        $preview = trim($request->input('preview',''));
        $new = trim($request->input('new',''));
        $hot = trim($request->input('hot',''));
        $content = trim($request->input('content',''));
        $image1 = trim($request->input('image1',''));
        $image2 = trim($request->input('image2',''));
        $image3 = trim($request->input('image3',''));
        $image4 = trim($request->input('image4',''));
        $image5 = trim($request->input('image5',''));
        $images = array($image1,$image2,$image3,$image4,$image5);
        // judge the input
        if ($id == '' || $name == ''|| $brief == '' || $price == ''){
            $m3Restult->status = 1;
            $m3Restult->message = 'id, name, brief, price should not be empty';
            return $m3Restult->toJson();
        }
        if(!preg_match("/[\d]*.?[\d]*/",$price)) {
            $m3Restult->status = 2;
            $m3Restult->message = 'price should be number';
            return $m3Restult->toJson();
        }
        // whether the category id is sub category
        $category = Category::where('parent_id','!=',0)->where('id',$categoryId)->first();
        if ($category == null){
            $m3Restult->status = 3;
            $m3Restult->message = 'no such category';
            return $m3Restult->toJson();
        }

        $product = Product::where('id',$id)->first();
        // store the data in to database
        $product->product_name = $name;
        $product->summary = $brief;
        $product->preview = $preview;
        $product->price = $price;
        $product->category_id = $categoryId;
        $product->new = $new;
        $product->hot = $hot;
        $product->save();

        $pdtContent = PdtContent::where('product_id',$product->id)->first();
        $pdtContent->product_id = $product->id;
        $pdtContent->content = $content;
        $pdtContent->save();
        // delete all images ,then add the updated ones
        PdtImages::where('product_id',$product->id)->delete();
        foreach ($images as $image) {
            if ($image != ''){
                $pdtImage = new PdtImages();
                $pdtImage->image_path = $image;
                $pdtImage->product_id = $product->id;
                $pdtImage->save();
            }
        }
        $m3Restult->status = 0;
        $m3Restult->message = 'add product successfully';
        return $m3Restult->toJson();
    }
}
