<?php
header('Content-Type: text/html; charset=gbk');
require '../config.php';
require '../lib/Template/template.php';
//��������
$sms = array(
    'action' => 'http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/', //���͵��ĵ�ַ
    'uid' => 'clarisonic2014lucky', //�ʺ�
    'pwd' => 'ccegroup2014', //����
    'mobile' => '', //�ֻ���
    'msg' => '��л���Ĳ��롣����������ױ��', //���Ͷ�������
    'dtime' => '' //����ʱ�䣬ʱ��Ϊ��Ϊ��������,��ʽ:2007-12-01 00:00:00
);

include $template->getfile('sys/sms_test');
