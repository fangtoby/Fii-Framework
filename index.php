<?php

//错误等级

//ini_set('display_errors', 'off');

//时区设置

ini_set('date.timezone','Asia/Shanghai');

//开发、上线参数

defined('ENV_DEBUG') or define('ENV_DEBUG',true);

define('PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);


$fii = PATH_ROOT . 'Fii.php';

$config = PATH_ROOT . 'protected/config/main.php';


require_once( $fii );

Fii::app()->ApplicationInit($config);

//http://www.fly.cc/index.php?path=index/index&name=fly&password=wr342

exit;

header('Content-Type: text/html; charset=UTF-8');

include "./view/index.php";