<?php

namespace App\Tools\SMS;

use App\InterfaceService\M3Result;

class SendTemplateSMS
{
  //主帐号
  private $accountSid='aaf98f8949d575140149dd482efa04b5';

  //主帐号Token
  private $accountToken='c7a1c3563b1347f4adbe0734f981dac1';

  //应用Id
  private $appId='8a48b55149d5792d0149dd63a3c4046d';

  //请求地址，格式如下，不需要写https://
  private $serverIP='sandboxapp.cloopen.com';

  //请求端口
  private $serverPort='8883';

  //REST版本号
  private $softVersion='2013-12-26';

  /**
    * 发送模板短信
    * @param to 手机号码集合,用英文逗号分开
    * @param datas 内容数据 格式为数组, 第一个是验证码内容，第二个是有效时间 例如：array('Marry',5)，如不需替换请填 null
    * @param $tempId 模板Id
    */
  public function sendSMS($to,$datas,$tempId)
  {
       $m3_result = new M3Result;

       // 初始化REST SDK
       $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
       $rest->setAccount($this->accountSid,$this->accountToken);
       $rest->setAppId($this->appId);

       // 发送模板短信
      //  echo "Sending TemplateSMS to $to <br/>";
       $result = $rest->sendTemplateSMS($to,$datas,$tempId);
       if($result == NULL ) {
           $m3_result->status = 3;
           $m3_result->message = 'result error!';
       }
       if($result->statusCode != 0) {
           $m3_result->status = $result->statusCode;
           $m3_result->message = $result->statusMsg;
       }else{
           $m3_result->status = 0;
           $m3_result->message = 'send successfully';
       }
       return $m3_result;
  }
}

// example
// phone number：18576437523， code：1234， valid time：5，tmplate：1
//sendSMS("18576437523", array(1234, 5), 1);