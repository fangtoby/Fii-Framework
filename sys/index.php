<?php
/**
 * 运营后台登录及登录后首页
 */
header('Content-Type: text/html; charset=UTF-8');
require '../config.php';
require '../common/global.func.php';
require '../common/DB.class.php';
require '../common/Error.class.php';

switch ($act) {
    case 'login':
        $user = trim($_POST['user']);
        if ($user) {
            //session_start();
            //if ($_SESSION['captcha'] == $_POST['code']) {
                $pass= md5($_POST['pass']);
                $db = new DB();
                $link = $db->get_MySQL_Link();
                if (!$db->isOK) {
                    echo 1; exit;
                }
                $user = mysql_real_escape_string($user);
                $sql = "SELECT admin_id, username, password FROM admin WHERE username='$user' AND flag=0 ";
                $res = mysql_query($sql);
                if (mysql_num_rows($res) == 1) {
                    $row = mysql_fetch_row($res);
                    if ($row[2] == $pass) {
                        if ($_POST['autoLogin'] == 1) {
                            cookie('sysUser', $row[0] . "\t" . $row[1], 86400 * 365);
                        } else {
                            cookie('sysUser', $row[0] . "\t" . $row[1]);
                        }
                        $sql = "UPDATE admin SET login_time='$time' WHERE admin_id='{$row[0]}'";
                        mysql_query($sql);
                        echo 'ok';
                    } else echo 1; //帐号密码错误
                } else echo 1;
            //} else echo 2;//验证码错误
        } else echo 1;
        break;

    case 'logout':
        clearCookie('sysUser');
        location('./');
        break;

    default:
        require '../lib/Template/template.php';
        if ($sysId) {
            include $template->getfile('sys/index');
        } else {
            include $template->getfile('sys/login');
        }
        break;
}