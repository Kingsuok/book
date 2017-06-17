<?php

namespace App\Http\Controllers\Service\Common;


use App\Http\Models\TempPhone;
use App\InterfaceService\M3Result;
use App\Tools\code\ValidateCode;
use App\Http\Controllers\Controller;
use App\Tools\SMS\SendTemplateSMS;
use Illuminate\Http\Request;


class ValidateController extends CommonController
{
    // create the validate code
    public function createCode(Request $request){
        $validateCode = new ValidateCode();// create validate code
        $request->session()->put('validateCode',$validateCode->getCode());// store validate code into session
        return $validateCode->doimg(); // return validate code
    }

    // send the phone validate code
    public function sendSMS(Request $request) //参数前不加类型，这里是为了说明变量含义，加上类型
    {
        $phone = $request->input('phone','');

        // deal the phone number is empty
        if ($phone == ''){
            $SMSResult = new M3Result();
            $SMSResult->status = 1;
            $SMSResult->message = 'Phone number should not be empty!';
            return $SMSResult->toJson();
        }
        // get random validate 6 digits code
        $code = '';
        $charset = '0123456789';// data source
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $period = 60; // set the validate period : 60 minutes
        $sendTemplateSMS = new SendTemplateSMS();
        $sendResult = $sendTemplateSMS->sendSMS($phone,array($code,$period),1);

        // store to database
        // judge the phone is recorded or not
        $tempPhone = TempPhone::where('phone',$phone)->first();
        // if the phone is not recorded, new a new record; or update the record
        if ($tempPhone == null){
            $tempPhone = new TempPhone();
        }

        $tempPhone->phone = $phone;
        $tempPhone->code = $code;
        // use date to transform timestamp(int) to string
        $tempPhone->deadline = date('Y-m-d H:i:s', time()+ $period * 60);
        $tempPhone->save();
        return $sendResult->toJson();
    }
}
