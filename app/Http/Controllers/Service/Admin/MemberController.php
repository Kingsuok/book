<?php

namespace App\Http\Controllers\Service\Admin;


use App\Http\Models\Member;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    // store the new member
    public function storeMember(Request $request)
    {
    }
    // delete a member
    public function deleteMember(Request $request)
    {
        $m3Result = new M3Result();
        $id = $request->input('id','');
        if ($id == ''){
            $m3Result->status = 1;
            $m3Result->message = 'id should not be empty';
        }else{
            Member::where('id',$id)->delete();
            $m3Result->status = 0;
            $m3Result->message = 'delete successfully';
        }
        return $m3Result->toJson();
    }
    // update a member
    public function updateMember(Request $request)
    {

    }
}
