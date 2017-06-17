<?php

namespace App\Http\Controllers\View\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends CommonController
{
    public function login(Request $request){
        // get the last url address, if not exist, the parameter is ''
        $returnURL = $request->input('returnURL','');
        $returnURL = urldecode($returnURL);// decode the url
        return view('home.login',compact('returnURL'));
    }

    public function register()
    {
        return view('home.register');
    }
}
