<?php

namespace App\Http\Controllers\Service\Home;

use App\Http\Models\Category;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //get the sub category
    public function category($parentId)
    {
        $subCategorys = Category::where('parent_id',$parentId)->get();
        $m3Result = new M3Result();
        if ($subCategorys == null){
            $m3Result->status = 1;
            $m3Result->message = "no sub categories!";
            return $m3Result->toJson();
        }
        $m3Result->status = 0;
        $m3Result->message = "successfully!";
        $m3Result->result = $subCategorys;
        return $m3Result->toJson();
    }
}
