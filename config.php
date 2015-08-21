<?php
/**
 * 网站配置文件.
 * @author hardywalker@hotmail.com
 * @version 1.0
 */
ini_set('display_errors', 'off');
//error_reporting(E_ALL && ~E_NOTICE);
ini_set('date.timezone','PRC');

define('CURSCRIPT', basename($_SERVER['PHP_SELF']));

define('ROOT', dirname(__FILE__) . '/');

//define('SITE_URL', 'http://test/jhs/');

define('SITE_URL', 'http://aplotion.comeyes.cn/');

define('LIB_URL', SITE_URL. 'lib/');

define('JQ_URL', LIB_URL. 'jquery/jquery.min.js');

//站点配置
$cfgSite = array(
    'title' => '阿玛尼',

);

//数据库配置
//$cfgDb = array(
//    'host' => 'localhost',
//    'user' => 'root',
//    'pass' => '111111',
//    'name' => 'armani'
//);
$cfgDb = array(
    'host' => 'localhost',
    'user' => 'aplotion_comeyes',
    'pass' => 'yR2HV931tB',
    'name' => 'aplotion_comeyes_cn'
);

//模板配置
$cfgTpl = array(
    'template_dir' => ROOT . 'tpl/', //指定模板文件存放目录
    'cache_dir' => ROOT . 'tpl/cache/', //指定缓存文件存放目录
    'auto_update' => true, //当模板文件有改动时重新生成缓存 [关闭该项会快一些]
    'cache_lifetime' => 0, //缓存生命周期(分钟)，为 0 表示永久 [设置为 0 会快一些]
    'suffix' => '.html'    //模板后缀
);


//管理登录
if (isset($_COOKIE['sysUser'])){
    list($sysId, $sysName) = explode("\t", $_COOKIE['sysUser']);
}

//其他
$act = $_REQUEST['act'];
$redirect = $_REQUEST['redirect'] ? $_REQUEST['redirect'] : $_SERVER['HTTP_REFERER'];
$time = time();