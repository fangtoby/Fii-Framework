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


    default:
        require '../common/Page.class.php';
        $sql = "SELECT * FROM shop WHERE flag=0 ";
        $kw = trim($_GET['kw']);
        if ($kw) {
            if (is_numeric($kw)) $sql .= " AND ShopID='$kw' ";
            else {
                $str = mysql_real_escape_string($kw);
                $sql .= " AND (ShopCode='$str' OR ShopName LIKE '%$str%' OR CityName LIKE '%$str%') ";
            }
        }
        $sql .= " ORDER BY id ASC LIMIT 20 ";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = mysql_query($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $list[] = $row;
        }
        $endpage = $page->EndPage(3, 1);
        include $template->getfile('sys/shop');
        break;
}
