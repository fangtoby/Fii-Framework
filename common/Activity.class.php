<?php
/**
 * 活动相关类.
 * Created by PhpStorm.
 * User: HardyWalker
 * Date: 15-8-2
 * Time: 下午7:50
 */
class Activity
{
    var $link;
    var $aid; //活动id
    var $arrAct;//活动属性

    function __construct($aid)
    {
        global $link;
        $this->link = $link;
        $this->aid = $aid;
        $this->arrAct = $this->getActivity($aid);
    }

    /**
     * 获取活动属性.
     * @param int $aid
     * @return array
     */
    function getActivity($aid) {
        return array(
            'activityId' => $aid,
            'totalLimitCnt' => 400,
            'dayLimitCnt' => 40, //为0不限制
            'startDate' => '2015-08-10',
            'endDate' => '2015-08-19'
        );
    }

    /**
     * 今日中奖数.
     * @return int
     */
    function todayWinCnt() {
        $today = date('Y-m-d');
        $sql = "SELECT COUNT(1) FROM activity_record WHERE activity_id='{$this->aid}' AND win=1 AND
                FROM_UNIXTIME(join_time, '%Y-%m-%d')='$today' ";
        $res = mysql_query($sql, $this->link);
        $row = mysql_fetch_row($res);
        return $row[0];
    }

    /**
     * 总中奖数.
     * @return int
     */
    function totalWinCnt() {
        $sql = "SELECT COUNT(1) FROM activity_record WHERE activity_id='{$this->aid}' AND win=1";
        $res = mysql_query($sql, $this->link);
        $row = mysql_fetch_row($res);
        return $row[0];
    }

    /**
     * 中奖剩余.
     * @return int
     */
    function diffWinCnt() {
        $diffWinCnt = 0;
        $today = date('Y-m-d');
        $totalWinCnt = $this->totalWinCnt();
        if ($today <= $this->arrAct['endDate'] && $totalWinCnt < $this->arrAct['totalLimitCnt']) {
            $diffCnt = $this->arrAct['totalLimitCnt'] - $totalWinCnt;//总剩余数
            if ($this->arrAct['dayLimitCnt'] > 0) {
                $todayWinCnt = $this->todayWinCnt($this->aid);
                if ($diffCnt > $this->arrAct['dayLimitCnt'])
                    $diffWinCnt = $this->arrAct['dayLimitCnt'] - $todayWinCnt;
                else $diffWinCnt = $diffCnt - $todayWinCnt;
            } else $diffWinCnt = $diffCnt;
        }
        return $diffWinCnt;
    }

    /**
     * 是否中奖.
     * @param int $isWin
     * @return bool
     */
    function winPrize($isWin = 0) {
        $diffWinCnt = $this->diffWinCnt();
        if ($isWin == 1 && $diffWinCnt >= 1) {
            return true; //$isWin=1必中，后台测试
        } else {
            $num = mt_rand(1, 100);
            if ($num % 2 == 1 && $diffWinCnt >= 1) return true;//余数1中奖
            else return false;
        }
    }

    /**
     * 保存用户提交信息.
     * @param string $mobile
     * @param int $ShopID
     * @param int $winPrize
     * @return bool
     */
    function saveInfo($mobile, $ShopID, $winPrize = 0) {
        $time = time();
        $sms = true;
        $sql = "SELECT id, win, join_time FROM activity_record WHERE activity_id='{$this->aid}' AND mobile='$mobile' ";
        $res = mysql_query($sql, $this->link);
        if (mysql_num_rows($res) == 1) {
            $row = mysql_fetch_row($res);
            if ($row[1] == 0) { //之前未中奖
                $sql = "UPDATE activity_record SET ShopID='$ShopID', join_time='$time',
                        join_cnt=join_cnt+1, win='$winPrize' WHERE id='{$row[0]}'";
            } else { //之前已中奖
                $sql = ''; $sms = false;//不可发短信
            }
        } else {
            $sql = "INSERT INTO activity_record SET mobile='$mobile', ShopID='$ShopID',
                    join_time='$time', join_cnt=join_cnt+1, activity_id='{$this->aid}',win='$winPrize' ";
        }
        if ($sql) mysql_query($sql);
        return $sms;
    }


    /**
     * 模拟post进行url请求.
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    function curlPost($url = '', $param = '') {
        if (!$url || !$param) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    /**
     * 发送短信.
     * @param string $mobile
     * @param string $msg
     */
    function sendSMS($mobile, $msg) {
        if ($mobile && $msg) {
            $url = 'http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/';
            $data = array(
                'uid' => 'clarisonic2014lucky', //帐号
                'pwd' => 'ccegroup2014', //密码
                'mobile' => $mobile, //手机号
                'msg' => iconv("UTF-8", "GBK//IGNORE", $msg), //发送短信内容
                'dtime' => '' //发送时间，时间为空为立即发送,格式:2007-12-01 00:00:00
            );
            $param = http_build_query($data);
            $this->curlPost($url, $param);
        }
    }

}