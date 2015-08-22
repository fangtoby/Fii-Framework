<?php
/**
 * 接收活动数据.
 * Created by PhpStorm.
 * User: HardyWalker
 * Date: 15-8-2
 * Time: 下午7:34
 */
header('Content-Type: text/html; charset=UTF-8');
require 'config.php';
require 'common/DB.class.php';
require 'common/Activity.class.php';

$resCode = 0;
$mobile = trim($_POST['mobile']);
if (is_numeric($mobile) && strlen($mobile) == 11) {

    $isWin = intval($_POST['isWin']); //为1必中
    $ShopID = intval($_POST['ShopID']);
    $activityId = intval($_POST['activityId']);
    if (!$activityId) $activityId = 1; //默认活动：全新黑钥匙「赋活水」

    $db = new DB();
    $link = $db->get_MySQL_Link();
    if ($db->isOK) {
        $Activity = new Activity($activityId);
        if ($Activity->winPrize($isWin)) {
            $winPrize = 1;
            $sql = "SELECT ShopName FROM shop WHERE ShopID='$ShopID'";
            $res = mysql_query($sql);
            $row = mysql_fetch_row($res);
            $ShopName = $row[0];
            $msg = "感谢您的申领，请在7天内凭短信莅临阿玛尼{$ShopName}美妆专柜，领取全新「黑钥匙」体验装一份。（数量有限，领完即止）本活动最终解释权归阿玛尼所有。【阿玛尼美妆】";
        } else {
            $winPrize = 0;
            $msg = "感谢您的参与，全新「黑钥匙」体验装今日申领活动已截止。（数量有限，领完即止）本活动最终解释权归阿玛尼所有。【阿玛尼美妆】";
        }
        //保存提交数据
        if ($Activity->saveInfo($mobile, $ShopID, $winPrize)) {
            $Activity->sendSMS($mobile, $msg); //发送短信
        } else $resCode = 2;
    } else $resCode = 1;

}

$data = array("resCode"=>"$resCode");
echo json_encode($data);
