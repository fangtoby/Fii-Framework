<?php
/** 导出excel */
header('Content-Type: text/html; charset=UTF-8');
require '../config.php';
require '../common/DB.class.php';
require "../lib/PHPExcel/PHPExcel.php";

$db = new DB();
$link = $db->get_MySQL_Link();

$type = intval($_GET['type']);//0全部 1已中奖 2未中奖
$sql = "SELECT a.mobile, a.join_time, a.win, b.ShopName, b.CityName
        FROM activity_record a, shop b
        WHERE a.ShopID=b.ShopID AND a.activity_id=1 ";
if ($type == 1) {
    $title = '活动中奖记录';
    $sql .= " AND a.win=1 ";
}
elseif ($type == 2) {
    $title = '活动未中奖记录';
    $sql .= " AND a.win=0 ";
}
else $title = '活动全部记录';
$sql .= " ORDER BY a.join_time DESC ";

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Armani")
    ->setLastModifiedBy("Armani")
    ->setTitle("Armani Activity");

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->getDefaultStyle()->getFont()->setName('宋体');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->setCellValue('A1', '手机');
$objPHPExcel->getActiveSheet()->setCellValue('B1', '城市');
$objPHPExcel->getActiveSheet()->setCellValue('C1', '柜台');
$objPHPExcel->getActiveSheet()->setCellValue('D1', '时间');
$objPHPExcel->getActiveSheet()->setCellValue('E1', '中奖');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$i = 2;
$str = '';
$arrWin = array('否', '是');
$res = mysql_query($sql);
while ($row = mysql_fetch_assoc($res)) {
    $joinTime = date('Y-m-d H:i:s', $row['join_time']);
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, (string)$row['mobile']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, (string)$row['CityName']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, (string)$row['ShopName']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, (string)$joinTime);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, (string)$arrWin[$row['win']]);
    $i++;
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$filename = '全新阿玛尼黑钥匙「赋活水」申领' . $title . '.xls';
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type: application/vnd.ms-excel;");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header("Content-Disposition:attachment;filename=".$filename);
header("Content-Transfer-Encoding:binary");
header("Pragma: no-cache");
$objWriter->save("php://output");
//可能因为缓存不够大，而显示不完整，所以如下做个中转
//if (!is_dir(ROOT . 'temp_file/')) @mkdir(ROOT . 'temp_file/', 0777, true);
//$finalFileName = ROOT . 'temp_file/' . $filename;
//$fp = fopen($finalFileName, "w");
//fwrite($fp, $str);
//fclose($fp);
//echo file_get_contents($finalFileName);
