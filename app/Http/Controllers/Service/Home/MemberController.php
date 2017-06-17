<?php

namespace App\Http\Controllers\Service\Home;


use App\Http\Models\TempEmail;
use App\InterfaceService\M3Email;
use App\InterfaceService\M3Result;
use App\Tools\UUID;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\TempPhone;
use App\Http\Models\Member;

use Mail;
class MemberController extends Controller
{
    // user register
    public function register(Request $request)
    {
        // get the input data
        $email = trim($request->input('email', ''));
        $phone = trim($request->input('phone', ''));
        $password = trim($request->input('password', ''));
        $confirm = trim($request->input('confirm', ''));
        $phoneCode = trim($request->input('phone_code', ''));
        $validateCode = trim($request->input('validate_code', ''));

        // verify the input data
        $m3Result = new M3Result();

        if ($email == '' && $phone == '') {
            $m3Result->status = 1;
            $m3Result->message = 'phone or email should not be empty!';
            return $m3Result->toJson();
        }

        if ($password == '' || strlen($password) < 6) {
            $m3Result->status = 2;
            $m3Result->message = 'password should not be less than 6 digits!';
            return $m3Result->toJson();
        }
        if ($confirm == '' || strlen($confirm) < 6) {
            $m3Result->status = 3;
            $m3Result->message = 'password should not be less than 6 digits!';
            return $m3Result->toJson();
        }
        if ($password != $confirm) {
            $m3Result->status = 4;
            $m3Result->message = 'twice passwords are not same!';
            return $m3Result->toJson();
        }

        // phone register
        if ($phone != '') {
            if (strlen($phone) != 10) {
                $m3Result->status = 9;
                $m3Result->message = 'phone is wrong!';
                return $m3Result->toJson();
            }
            if ($phoneCode == '' || strlen($phoneCode) != 6) {
                $m3Result->status = 5;
                $m3Result->message = 'code is 6 digits';
                return $m3Result->toJson();
            }
            // check validate code
            $tempPhone = TempPhone::where('phone', $phone)->first();
            if ($tempPhone->code == $phoneCode) {
                // check whether it is out of date
                if (time() > strtotime($tempPhone->deadline)) {
                    $m3Result->status = 7;
                    $m3Result->message = 'code is wrong';
                    return $m3Result->toJson();
                }

                // save the member info
                $member = new Member();
                $member->phone = $phone;
                $member->password = md5('bk' . $password);// md5 encrypt the password
                $member->save();


                $m3Result->status = 0;
                $m3Result->message = 'register successfully';
                return $m3Result->toJson();
            } else {
                $m3Result->status = 7;
                $m3Result->message = 'code is wrong';
                return $m3Result->toJson();
            }

            // 邮箱注册
        } else {

            if (strpos($email, '@') === false || strpos($email, '.') === false) {
                $m3Result->status = 10;
                $m3Result->message = 'email is wrong!';
                return $m3Result->toJson();
            }
            if ($validateCode == '' || strlen($validateCode) != 4) {
                $m3Result->status = 6;
                $m3Result->message = 'code is 4 digits';
                return $m3Result->toJson();
            }

            // get the validate code stored in session
            $validateCodeSession = $request->session()->get('validateCode', '');
            // verify the validate code
            if ($validateCodeSession != strtolower($validateCode)) {
                $m3Result->status = 8;
                $m3Result->message = 'code is wrong';
                return $m3Result->toJson();
            }

            // store the new member
            // save the member info
            $member = Member::where('email',$email)->first();
            if ($member == null){
                $member = new Member();
                $member->email = $email;
                $member->password = md5('bk' . $password);// md5 encrypt the password
                $member->save();
            }else{
                if ($member->email_active == 1){
                    // successfully tip
                    $m3Result->status = 11;
                    $m3Result->message = 'email have been registered';
                    return $m3Result->toJson();
                }
                $member->password = md5('bk' . $password);// md5 encrypt the password
                $member->save();
            }

            // get the UUID for email validation
            $uuId = UUID::create();// get uuid code

            // store the temp email info for verify the new account
            $tempEmail = TempEmail::where('member_id',$member->id)->first();
            if ($tempEmail == null){
                $tempEmail = new TempEmail();
                $tempEmail->member_id = $member->id;
                $tempEmail->code = $uuId;
                $tempEmail->deadline = date('Y-m-d H:i:s', time() + 24 * 60 * 60);
                $tempEmail->save();
            }else{
                $tempEmail->code = $uuId;
                $tempEmail->deadline = date('Y-m-d H:i:s', time() + 24 * 60 * 60);
                $tempEmail->save();
            }

            //set email
            $url = $_SERVER['SERVER_NAME'].'/service/validateEmail';// email active address
            $m3Email = new M3Email();
            //$m3Email->from =
            $m3Email->to = $email;
            $m3Email->cc = 'suwangok@gmail.com';// this is not necessary
            $m3Email->subject = 'Book Market Validation';
            $m3Email->content = '<a href='.$url.'?memberId='.$member->id
                                .'&code='.$uuId.'>Please click here to active your account in 24 hours.</a>';
            Mail::send('emails.email', ['m3Email' => $m3Email], function ($m) use ($m3Email) {
                //$m->from('hello@app.com', 'Your Application');
                $m->to($m3Email->to, 'Dear user')
                    ->cc($m3Email->cc)
                    ->subject($m3Email->subject);
            });


            // successfully tip
            $m3Result->status = 0;
            $m3Result->message = 'register successfully';
            return $m3Result->toJson();
        }
    }

    // validate email
    public function validateEmail(Request $request)
    {
        // get the memberId and UUID
        $memberId = $request->input('memberId','');
        $code = $request->input('code','');

        if ($memberId == '' || $code == ''){
            return 'validation error';
        }

        $tempEmail = TempEmail::where('member_id',$memberId)->first();
        if ($tempEmail == null){
            return 'validation error';
        }else{
            if ($code == $tempEmail->code){
                if (time() > strtotime($tempEmail->deadline)){
                   return "link expired" ;
                }
                $member = Member::find($memberId);
                $member->email_active = 1;
                $member->save();

                return redirect('/login'); // validation successfully, jump to login interface
            }else{
                return "validation error";
            }
        }
    }

    // login
    public function login(Request $request)
    {
        $account = trim($request->input('account',''));
        $password = trim($request->input('password',''));
        $code = trim($request->input('code',''));

        $m3Result = new M3Result();// status message
        // verify the input
        if ($account == '') {
            $m3Result->status = 1;
            $m3Result->message = 'phone or email should not be empty!';
            return $m3Result->toJson();
        }
        if (strpos($account,'@') === false){
            if (strlen($account) != 10){
                $m3Result->status = 9;
                $m3Result->message = 'Phone is wrong!';
                return $m3Result->toJson();
            }
        }else{
            if (strpos($account,'.') === false){
                $m3Result->status = 10;
                $m3Result->message = 'Email is wrong!';
                return $m3Result->toJson();
            }
        }

        if ($password == '' || strlen($password) < 6) {
            $m3Result->status = 2;
            $m3Result->message = 'password should not be less than 6 digits!';
            return $m3Result->toJson();
        }
        if ($code == '' || strlen($code) != 4) {
            $m3Result->status = 7;
            $m3Result->message = 'Code should be 4 digits!';
            return $m3Result->toJson();
        }

        //verify the validate code first
        $sessionCode = $request->session()->get('validateCode','');
        if (strtolower($code) != $sessionCode){
            $m3Result->status = 8;
            $m3Result->message = 'Code is wrong!';
            return $m3Result->toJson();
        }
        //check the account and password
        $member = null;
        if (strpos($account,'@') !== false){
            $member = Member::where('email',$account)->first();
        }else{
            $member = Member::where('phone',$account)->first();
        }

        if ($member == null){
            $m3Result->status = 12;
            $m3Result->message = 'Account does not exist!';
            return $m3Result->toJson();
        }else{
            $password = md5('bk'. $password);
            if ($member->password != $password){
                $m3Result->status = 13;
                $m3Result->message = 'Password is wrong!';
                return $m3Result->toJson();
            }
        }

        //store the member's info using session
        $request->session()->put('member',$member);



        // login successfully
        $m3Result->status = 0;
        $m3Result->message = 'Login successfully';


        return $m3Result->toJson();
    }
    // logout
    public function logout()
    {
        $m3Result = new M3Result();// status message
        session(['member'=>null]); // clear the session,也可以使用$request 进行操作session
        $m3Result->status = 0;
        $m3Result->message = 'logout successfully';
        return $m3Result->toJson();
    }

}
