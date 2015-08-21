<?php
header('Content-Type: text/html; charset=gbk');
require '../config.php';
require '../lib/Template/template.php';
//短信配置
$sms = array(
    'action' => 'http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/', //发送到的地址
    'uid' => 'clarisonic2014lucky', //帐号
    'pwd' => 'ccegroup2014', //密码
    'mobile' => '', //手机号
    'msg' => '感谢您的参与。【阿玛尼美妆】', //发送短信内容
    'dtime' => '' //发送时间，时间为空为立即发送,格式:2007-12-01 00:00:00
);

include $template->getfile('sys/sms_test');
