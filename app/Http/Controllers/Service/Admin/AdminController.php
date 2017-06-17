<?php

namespace App\Http\Controllers\Service\Admin;


use App\Http\models\Admin;
use App\Http\Models\Member;
use App\InterfaceService\M3Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $m3Result = new M3Result();// status message

        $account = trim($request->input('account',''));
        $password = trim($request->input('password',''));
        $code = trim($request->input('code',''));

        // verify the input
        if ($account == '') {
            $m3Result->status = 1;
            $m3Result->message = 'Account should not be empty!';
            return $m3Result->toJson();
        }


        if ($password == '' || strlen($password) < 6) {
            $m3Result->status = 2;
            $m3Result->message = 'password should not be less than 6 digits!';
            return $m3Result->toJson();
        }
        if ($code == '' || strlen($code) != 4) {
            $m3Result->status = 3;
            $m3Result->message = 'Code should be 4 digits!';
            return $m3Result->toJson();
        }

        //verify the validate code first
        $sessionCode = $request->session()->get('validateCode','');
        if (strtolower($code) != $sessionCode){
            $m3Result->status = 4;
            $m3Result->message = 'Code is wrong!';
            return $m3Result->toJson();
        }

        //check the account and password
        $admin = Admin::where('name',$account)->first();

        if ($admin == null){
            $m3Result->status = 5;
            $m3Result->message = 'Account does not exist!';
            return $m3Result->toJson();
        }else{
            $password = md5('bk'. $password);
            if ($admin->password != $password){
                $m3Result->status = 6;
                $m3Result->message = 'Password is wrong!';
                return $m3Result->toJson();
            }
        }
        //store the member's info using session
        $request->session()->put('admin',$admin);



        // login successfully
        $m3Result->status = 0;
        $m3Result->message = 'Login successfully';


        return $m3Result->toJson();

    }

    // logout
    public function logout()
    {
        // clear session
        session(['admin'=>null]);
        $m3Result = new M3Result();// status message
        $m3Result->status = 0;
        $m3Result->message = 'logout successfully';
        return $m3Result->toJson();
    }
    // edit password
    public function edit(Request $request)
    {

        $adminName = trim($request->input('adminName',''));
        $oldPassword = trim($request->input('oldPassword',''));
        $newPassword = trim($request->input('newPassword',''));
        $confirmPassword = trim($request->input('confirmPassword',''));

        $m3Result = new M3Result();
        if ($adminName == '' || $oldPassword == ''|| $newPassword == ''|| $confirmPassword == ''){
            $m3Result->status = 1;
            $m3Result->message = 'all input should not be empty';
            return $m3Result->toJson();
        }
        $oldPassword = md5('bk' . $oldPassword);
        $adminSession = session('admin');
        if ($adminSession->password != $oldPassword){
            $m3Result->status = 2;
            $m3Result->message = 'old password is wrong';
            return $m3Result->toJson();
        }
        if (strlen($newPassword) < 6 || strlen($newPassword)>16 ){
            $m3Result->status = 3;
            $m3Result->message = 'new password should be 6 ~ 16 digits';
            return $m3Result->toJson();
        }
        if ($newPassword != $confirmPassword){
            $m3Result->status = 3;
            $m3Result->message = 'twice passwords are not same';
            return $m3Result->toJson();
        }
        $admin = Admin::where('id',$adminSession->id)->first();
        $admin->name = $adminName;
        $admin->password = md5('bk' . $newPassword);
        $admin->save();
        $m3Result->status = 0;
        $m3Result->message = 'edit admin successfully';
        return $m3Result->toJson();
    }
}
