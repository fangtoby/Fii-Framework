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
        $activity_id = intval($_GET['activity_id']);
        if (!$activity_id) $activity_id = 1;
        $sql = "SELECT a.*, b.ShopName, b.CityName FROM activity_record a,shop b
                WHERE a.ShopID=b.ShopID AND a.activity_id='$activity_id' ";
        if ($act == 'win') $sql .= " AND a.win=1 ";
        $kw = trim($_GET['kw']);
        if ($kw) {
            if (is_numeric($kw)) $sql .= " AND (a.mobile='$kw' OR a.ShopID='$kw') ";
            else {
                $str = mysql_real_escape_string($kw);
                $sql .= " AND b.ShopName like '%$str%' ";
            }
        }
        $sql .= " ORDER BY join_time DESC LIMIT 20 ";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = mysql_query($sql);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $list[$i] = $row;
            $list[$i]['join_time'] = $row['join_time'] ? date('Y-m-d H:i', $row['join_time']) : '';
            $i++;
        }
        $endpage = $page->EndPage(3, 1);
        include $template->getfile('sys/activity_record');
        break;
}
