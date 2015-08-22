<?php

//错误等级

//ini_set('display_errors', 'off');

//时区设置

ini_set('date.timezone','Asia/Shanghai');

//开发、上线参数

defined('ENV_DEBUG') or define('ENV_DEBUG',true);

define('DIR_SIGN', DIRECTORY_SEPARATOR);

define('PATH_ROOT', dirname(__FILE__) . DIR_SIGN);


$fii = PATH_ROOT . 'Fii.php';

$config = PATH_ROOT . 'protected'.DIR_SIGN.'config'.DIR_SIGN.'main.php';

require_once( $fii );

Fii::app()->ApplicationInit($config);

//http://www.fly.cc/index.php?path=index/index&name=fly&password=wr342

exit;

header('Content-Type: text/html; charset=UTF-8');

include "./view/index.php";

// 0. 开始
// 1. 错误等级
// 2. 时区设置
// 3. 框架配置、框架文件位置设置
// 4. 运行框架
// 5. 载入配置
// 6. 读取全局配置文件，设置拓展类库位置，载入类库
// 7. 读取全局配置文件，载入版本控制、设置静态文件路径、静态文件生成函数、添加
//    静态文件版本号
// 8. 分析路由、验证访问权限、运行相应的控制器相应函数，渲染视图
// 9. 结束

