<?php

namespace App\Http\Controllers\Service\Admin;


use App\Http\Models\Category;
use App\Http\Models\Product;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // store the new category
    public function storeCategory(Request $request)
    {
        $m3Restult = new M3Result();
        $categoryName = trim($request->input('categoryName',''));
        $categoryNo = trim($request->input('categoryNo',''));
        $parentId = trim($request->input('parentId',''));
        $preview = trim($request->input('preview',''));
        if ($categoryName == '' || $categoryNo ==''||$parentId == ''){
            $m3Restult->status = 1;
            $m3Restult->message = 'Name, No, Parent Name should not be empty';
        } else if(!preg_match("/^\d*$/",$categoryNo)) {
            $m3Restult->status = 2;
            $m3Restult->message = 'No should not be number';
        }else if(!preg_match("/^\d*$/",$parentId)) {
            $m3Restult->status = 3;
            $m3Restult->message = 'Parent Name should be number';
        }else{
            $category = new Category();
            $category->category_name = $categoryName;
            $category->category_no = $categoryNo;
            $category->parent_id = $parentId;
            $category->preview = $preview;
            $category->save();
            $m3Restult->status = 0;
            $m3Restult->message = 'add successfully';
        }
        return $m3Restult->toJson();
    }
    // delete a category
    public function deleteCategory(Request $request)
    {
        $m3Result = new M3Result();
        $id = $request->input('id','');
        $parentId = $request->input('parentId','');
        if ($id == ''){
            $m3Result->status = 1;
            $m3Result->message = 'id should not be empty';
        }else{
            Category::where('id', $id)->delete();
            // 因为就两级分类，如果删除的是顶级分类，则下面的子分类就变成了顶级分类
            if ($parentId == 0){
                $subCategorys = Category::where('parent_id',$id)->get();
                foreach ($subCategorys as $subCategory) {
                    $subCategory->parent_id = 0;
                    $subCategory->save();
                }
            }

            $m3Result->status = 0;
            $m3Result->message = 'delete successfully';
        }
        return $m3Result->toJson();
    }
    // update a category
    public function updateCategory(Request $request)
    {
        $m3Restult = new M3Result();
        $id = $request->input('id','');
        $categoryName = trim($request->input('categoryName',''));
        $categoryNo = trim($request->input('categoryNo',''));
        $parentId = trim($request->input('parentId',''));
        $preview = trim($request->input('preview',''));
        if ($categoryName == '' || $categoryNo ==''||$parentId == ''){
            $m3Restult->status = 1;
            $m3Restult->message = 'Name, No, Parent Name should not be empty';
        } else if(!preg_match("/^\d*$/",$categoryNo)) {
            $m3Restult->status = 2;
            $m3Restult->message = 'No should not be number';
        }else if(!preg_match("/^\d*$/",$parentId)) {
            $m3Restult->status = 3;
            $m3Restult->message = 'Parent Name should be number';
        }else{
            $category = Category::where('id',$id)->first();
            $category->category_name = $categoryName;
            $category->category_no = $categoryNo;
            $category->parent_id = $parentId;
            $category->preview =$preview;
            $category->save();
            $m3Restult->status = 0;
            $m3Restult->message = 'edit successfully';
        }

        return $m3Restult->toJson();
    }
}
