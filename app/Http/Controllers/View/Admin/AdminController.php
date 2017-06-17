<?php

namespace App\Http\Controllers\View\Admin;
use Log;

class AdminController extends CommonController
{
    // 由www.book.com/admin访问时admin login interface
    public function toLogin()
    {
        // check whether login or not
        // if login: to index

        //if no login : to login interface
        return view('admin.login');
    }
    //modify password
    public function edit()
    {
        return view('admin.adminEdit');
    }

}
