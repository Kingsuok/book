<?php
/**
 * description： email interface
 * Created by PhpStorm.
 * User: su
 * Date: 2017/6/1
 * Time: 15:43
 */

namespace app\InterfaceService;


class M3Email
{
    public $from; //sender email address
    public $to; // receiver email address, 这里一个人指定字符串，多个人字符串数组
    public $cc; // copy to
    public $attach; // attachment
    public $subject; //
    public $content; //
}