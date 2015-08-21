<?php
header('Content-Type: text/html; charset=UTF-8');
require '../config.php';
require '../common/DB.class.php';
require '../common/Error.class.php';
require '../lib/Template/template.php';
$db = new DB();
$link = $db->get_MySQL_Link();
if (!$db->isOK) Error::exitWithJson(10001);

switch ($act) {

    case 'save':
        $admin_id = intval($_POST['admin_id']);
        $username = mysql_real_escape_string(trim($_POST['username']));
        if (!$username) { echo 0; exit;}
        $sql = "SELECT admin_id FROM admin WHERE username='$username' AND admin_id!='$admin_id' ";
        $res = mysql_query($sql);
        if (mysql_num_rows($res) > 0) { echo 2; exit;}//帐号已存在
        $password = trim($_POST['password']);
        if ($admin_id > 0) {
            $sql = "UPDATE admin SET username='$username' ";
            if ($password) {
                $md5_pwd = md5($password);
                $sql .= ", password='$md5_pwd' ";
            }
            $sql .= "WHERE admin_id='$admin_id' ";
        } else {
            if (!$password) {echo 0; exit;}
            else $md5_pwd = md5($password);
            $sql = "INSERT INTO admin SET username='$username', password='$md5_pwd', create_time='$time', login_time='$time'";
        }
        if (mysql_query($sql)) echo 1;
        else echo 0;
        break;

    case 'del':
        $id = intval($_POST['id']);
        $sql = "UPDATE admin SET flag=1 WHERE admin_id='$id'";
        if (mysql_query($sql)) echo 1;
        else echo 0;
        break;

    default:
        require '../common/Page.class.php';
        $sql = "SELECT * FROM admin WHERE flag=0";
        $kw = trim($_GET['kw']);
        if ($kw) {
            if (is_numeric($kw)) $sql .= " AND admin_id='$kw' ";
            else {
                $str = mysql_real_escape_string($kw);
                $sql .= " AND username like '%$str%' ";
            }
        }
        $sql .= " ORDER BY admin_id DESC LIMIT 20 ";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = mysql_query($sql);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $list[$i] = $row;
            $list[$i]['create_time'] = $row['create_time'] ? date('Y-m-d H:i', $row['create_time']) : '';
            $list[$i]['login_time'] = $row['login_time'] ? date('Y-m-d H:i', $row['login_time']) : '';
            $i++;
        }
        $endpage = $page->EndPage(3, 1);
        include $template->getfile('sys/admin');
        break;
}
