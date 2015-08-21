<?php
/**
 * 全局常用函数.
 *
 */

/**
 * set cookie
 * @param string $name
 * @param string $value
 * @param int $life
 * @param string $path
 * @param string $domain
 */
function cookie($name, $value, $life = 0, $path = '/', $domain = '')
{
    $S = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
    setcookie($name, $value, $life ? time() + $life : 0, $path, $domain, $S);
}

/**
 * clear cookie
 * @param string $name
 * @param string $path
 * @param string $domain
 */
function clearCookie($name, $path = '/', $domain = '')
{
    cookie($name, '', -86400 * 365, $path, $domain);
}

/**
 * html字符串格式化.
 * 替换掉html中的特殊字符
 * @param string $sHtml 需要处理的html
 * @return string
 */
function toHtmlChars($sHtml)
{
    $chars = array(
        '&' => '&amp;', '<' => '&lt;', '>' => '&gt;', '\'' => '&apos;',
        '"' => '&quot;', "\n"=>'<br />', ' '=>'&nbsp;'
    );
    return strtr($sHtml, $chars);
}

/**
 * 获取文件扩展名
 * @param $fileName
 * @return string
 */
function getFileExt($fileName)
{
    return strtolower(substr(strrchr($fileName, '.'), 1, 10));
}

/**
 * 随机字符串
 * @param int $len 字符串长度
 * @param int $type 0默认混合 1仅数字 2仅字母
 * @param int $upper 是否大写字母
 * @param int $repeat 重复次数
 * @return string
 */
function random($len, $type = 0, $upper = 0, $repeat = 0)
{
    $s1 = '1234567890';
    $s2 = 'abcdefghijklmnopqrstuvwxyz';
    $s = ($type==1)? $s1: (($type==2)? $s2: $s1.$s2);
    if ($upper) $s = strtoupper($s);
    if ($repeat) $s = str_repeat($s, $repeat);
    return substr(str_shuffle($s), 0, $len);//打乱字符
}

/**
 * alert 弹错框
 * @param string $str
 * @param string $url
 */
function alert($str, $url = '')
{
    if ($url) $script = "location='$url'";
    else $script = "history.back()";
    $script = '<script type="text/javascript">alert("'.$str.'");'.$script.';</script>';
    echo $script;
    exit;
}

/**
 * 跳转连接
 * @param string $url
 */
function location($url)
{
    header("location: $url"); exit;
}

/**
 * 多少时间前
 * @param $past
 * @return string
 */
function timeAgo($past)
{
    $time = time() - $past;
    $year = floor($time / 60 / 60 / 24 / 365);
    $time -= $year * 60 * 60 * 24 * 365;
    $month = floor($time / 60 / 60 / 24 / 30);
    $time -= $month * 60 * 60 * 24 * 30;
    $week = floor($time / 60 / 60 / 24 / 7);
    $time -= $week * 60 * 60 * 24 * 7;
    $day = floor($time / 60 / 60 / 24);
    $time -= $day * 60 * 60 * 24;
    $hour = floor($time / 60 / 60);
    $time -= $hour * 60 * 60;
    $minute = floor($time / 60);
    $time -= $minute * 60;
    $second = $time;
    $elapse = '';
    $unitArr = array('年' => 'year', '个月' => 'month', '周' => 'week', '天' => 'day',
        '小时' => 'hour', '分钟' => 'minute', '秒' => 'second');
    foreach ($unitArr as $cn => $u) {
        if ($$u > 0) {
            $elapse = $$u . $cn; break;
        }
    }
    return $elapse;
}

/**
 * 两个YYYY-MM-DD格式日期相差天数
 * @param string $date1 YYYY-MM-DD
 * @param string $date2 YYYY-MM-DD
 * @return float
 */
function getDiffDay($date1, $date2)
{
    $Date_List_a1 = explode("-", $date1);
    $Date_List_a2 = explode("-", $date2);
    $d1 = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);
    $d2 = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);
    $Days = round(($d1 - $d2) / 3600 / 24);
    return $Days;
}

/**
 * file_get_contents发送http get请求
 * @param $url
 * @return string
 */
function fgc($url)
{
    $opts = array(
        'http' => array(
            'method' => "GET",
            'timeout' => 2,
        )
    );
    $s = @file_get_contents("$url", false, stream_context_create($opts));
    return $s;
}
