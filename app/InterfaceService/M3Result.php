<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2017/5/31
 * Time: 15:58
 */

namespace App\InterfaceService;


class M3Result {

    public $status;// status: 0-> success, 1(2,3,...) ->error
    public $message;// message: the message of the corespondent status
    public $result;// generally, the result is the return data from server when status is 0

    public function toJson()
    {
        //注意：json_encode($this, JSON_UNESCAPED_UNICODE)的结果是一个string形式的json
        //string '{"status":1,"message":"Phone number should not be empty!"}'，
        //所以在ajax接收的数据要特别指明要以json格式接收数据，否则会使string
        return json_encode($this, JSON_UNESCAPED_UNICODE);// JSON_UNESCAPED_UNICODE for chinese characters
    }

}