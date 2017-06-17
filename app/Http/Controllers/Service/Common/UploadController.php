<?php

namespace App\Http\Controllers\Service\Common;


use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class UploadController extends CommonController
{
    // upload file, $type : images or files,
    //注意这里规定 $type 只能为images 和 files
    public function uploadFile(Request $request, $type)
    {
        $m3Result = new M3Result();
        $file = $request->file('image');// Filedata is the default parameter
        if($file->isValid()){ //check the file is valid or not
            $suffix = $file->getClientOriginalExtension();// get the suffix of the file
            if ($type == 'images' && !in_array(strtolower($suffix),array('png','jpg','jpeg','gif','bmp')) ){// control the size of the file
                $m3Result->status = 1;
                $m3Result->message = 'upload fail, it is not a image';
            }else if($file->getClientSize() > 1024 * 1024){
                $m3Result->status = 2;
                $m3Result->message = 'upload fail, size should not be bigger than 1M';
            }else{
                $newName = date('YmdHis').rand(100,999).'.'.$suffix;//201706130050442104.png
                $path = $file->move(public_path().'/uploads/'.$type,$newName); // move file and rename the file name,如果目录没有会自动建立目录
                $filePath = '/uploads/'.$type .'/'.$newName;// the name stored in database: www.book.com/upload/images/20170212012.png
                $m3Result->status = 0;
                $m3Result->message = 'upload successfully';
                $m3Result->result = $filePath;
            }
        }else{
            $m3Result->status = 3;
            $m3Result->message = 'upload fail, Unknown Error';
        }
        return $m3Result->toJson();
    }
}
