<?php

namespace App\Http\Controllers\View\Admin;
use App\Http\Models\Category;
use App\Http\Models\Member;
use Log;

class MemberController extends CommonController
{
    //GET, admin/member, all member list
    public function index()
    {
        $members = Member::orderBy('id','desc')->paginate(8);
        return view('admin.memberIndex',compact('members'));
    }
    //GET, admin/member/{member}, show a single member
    public function show($id)
    {

    }
    //GET, admin/member/create, add a new member
    public function create()
    {
    }
    //POST, admin/member. store the added new member
    public function store()
    {

    }
    //GET, admin/member/{member}/edit, edit a member
    public function edit($id)
    {
    }
    //PUT, admin/member/{member}, update a member
    public function update($id)
    {

    }
    //DELETE, admin/member/{member}, delete a  member
    public function destroy($id)
    {

    }
}
