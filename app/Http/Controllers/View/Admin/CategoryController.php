<?php

namespace App\Http\Controllers\View\Admin;
use App\Http\Models\Category;
use Log;

class CategoryController extends CommonController
{
    //GET, admin/category, all category list
    public function index()
    {
        $categorys = Category::orderBy('id','desc')->paginate(8);;
        $parents = Category::where('parent_id',0)->get();
        $parentsArray = array();
        foreach ($parents as $parent) {
            $parentsArray[$parent->id] = $parent->category_name;
        }
        return view('admin.categoryIndex',compact('categorys','parentsArray'));
    }
    //GET, admin/category/{category}, show a single category
    public function show($id)
    {

    }
    //GET, admin/category/create, add a new category
    public function create()
    {
        $parents = Category::where('parent_id',0)->get();
        return view('admin.categoryAdd',compact('parents'));
    }
    //POST, admin/category. store the added new category
    public function store()
    {

    }
    //GET, admin/category/{category}/edit, edit a category
    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        $parents = Category::where('parent_id',0)->get();
        return view('admin.categoryEdit',compact('category','parents'));
    }
    //PUT, admin/category/{category}, update a category
    public function update($id)
    {

    }
    //DELETE, admin/category/{category}, delete a  category
    public function destroy($id)
    {

    }
}
