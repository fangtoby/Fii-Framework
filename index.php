<?php

//错误等级

//ini_set('display_errors', 'off');

//时区设置

ini_set('date.timezone','Asia/Shanghai');

//开发、上线参数

defined('ENV_DEBUG') or define('ENV_DEBUG',true);


define('PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$config = PATH_ROOT . 'protected/config/main.php';


require_once( 'Data.php' );


Fii:app()->ApplicationInit($config);


echo $_SERVER['HTTP_HOST']."<br>";

echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";

echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

$test = parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);  

echo "<pre>";

print_r($test); 

exit;

header('Content-Type: text/html; charset=UTF-8');

include "./view/index.php";