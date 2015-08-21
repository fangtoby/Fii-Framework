<?php
/**
 * 分页类.
 * $sql = "select name from table limit 10";
 * $page = new Page($sql);
 * $sql=$page->StartPage();
 * $qy = mysql_query($sql);
 * while($rs = mysql_fetch_array($qy)){
 * echo $rs[1];
 * }
 * echo $page->EndPage();
 */
class Page
{

    var $PageSize = 10;//每页记录数
    var $TotalPage;//总页数
    var $NowPage;//当前第几页
    var $RecordNum;//记录总数
    var $QueryString;//查询语句
    var $pgo;
    var $anchor;
    var $prevStr;
    var $nextStr;

    function __construct($sql)
    {
        if (!mysql_ping()) {
            echo "Please check your database link"; exit;
        }
        if (trim($sql) != "") {
            if (preg_match("/limit/", $sql)) {
                list($sql, $limit) = explode("limit", $sql);
            } else if (preg_match("/LIMIT/", $sql)) {
                list($sql, $limit) = explode("LIMIT", $sql);
            }
            if (isset($limit)) {
                list($cnt1, $cnt2) = explode(",", $limit);
                if (!empty($cnt2)) {
                    $this->PageSize = $cnt2;
                } elseif (!empty($cnt1)) {
                    $this->PageSize = $cnt1;
                }
            }
            $this->QueryString = $sql;
            unset($cnt1, $cnt2);
        }
    }

    function InitSet($prevStr = "上一页", $nextStr = "下一页")
    {
        $this->prevStr = $prevStr;
        $this->nextStr = $nextStr;
    }

    //获取相应规定数目的记录并计算出总记录数，总页数等参数
    function StartPage()
    {
        $this->InitSet();
        $Result = mysql_query($this->QueryString);
        $this->RecordNum = mysql_num_rows($Result);
        $this->TotalPage = ceil($this->RecordNum / $this->PageSize);
        //获取url中传过来的当前页数，保证其为整数值
        if (isset($_REQUEST['page'])) {
            $this->NowPage = intval($_REQUEST['page']);
        }
        if ($this->NowPage <= 0) {
            $this->NowPage = 1;
        } elseif ($this->NowPage > $this->TotalPage) {
            $this->NowPage = $this->TotalPage;
        }
        $OffSet = $this->PageSize * ($this->NowPage - 1);
        if ($OffSet < 0) $OffSet = 0;
        $sql = $this->QueryString . " LIMIT " . $OffSet . "," . $this->PageSize;
        return $sql;
    }

    //显示翻页按扭,当总页数小于每页记录数时不显示分页, $z为命名锚记如#box
    function EndPage($x = 2, $y = 1, $z = '')
    {
        $this->anchor = $z;
        if ($y == 1) {
            $pgfl = "page-floatR";
            $this->pgo = "right0";
        } elseif ($y == 2) {
            $pgfl = "page-floatL";
            $this->pgo = "left0";
        } else {
            $pgfl = "page-floatC";
            $this->pgo = "right50";
        }
        $FirstPage = 1;
        $PrevPage = $this->NowPage - 1;
        $NextPage = $this->NowPage + 1;
        $LastPage = $this->TotalPage;
        if ($this->RecordNum > $this->PageSize) {
            $ReturnStr = "<div class=\"pagination\"><div class=\"$pgfl\">";
            $ReturnStr .= $this->ToPage($PrevPage, $this->prevStr, 'prev');
            $ReturnStr .= $this->DisPageNum($x);
            $ReturnStr .= $this->ToPage($NextPage, $this->nextStr, 'next');
            $ReturnStr .= "</div></div>";
        } else {
            $ReturnStr = '&nbsp;';
        }
        return $ReturnStr;
    }

    //创建翻页按扭，并根据$Flag的值来设置按扭是否可用
    //$Page 将要跳转的页数
    //$Msg 跳转按扭名称
    //$Flag 按扭显示类型
    function ToPage($Page, $Msg, $Flag = '')
    {
        $Url = $this->GetUrl($Page);
        $pgo = $this->pgo;
        $UrlStr = "<a class=\"$pgo\" href=\"" . $Url . "\">" . $Msg . "</a>";
        if ($Page < 1 || $Page > $this->TotalPage) {
            $UrlStr = '';
        }
        if ($Page == $this->NowPage) {
            $UrlStr = "<span class=\"page-cur {$pgo}\">" . $Msg . "</span>";
        }
        if ($Flag) {
            if ($this->NowPage <= 1 && $Flag == 'prev') {
                $UrlStr = "<span class=\"page-start {$pgo}\"><span>" . $Msg . "</span></span>";
            }
            if ($this->NowPage >= $this->TotalPage && $Flag == 'next') {
                $UrlStr = "<span class=\"page-end {$pgo}\"><span>" . $Msg . "</span></span>";
            }
            if ($this->NowPage > 1 && $Flag == 'prev') {
                $UrlStr = "<a href=\"" . $Url . "\" class=\"page-prev {$pgo}\"><span>" . $Msg . "</span></a>";
            }
            if ($this->NowPage < $this->TotalPage && $Flag == 'next') {
                $UrlStr = "<a href=\"" . $Url . "\" class=\"page-next {$pgo}\"><span>" . $Msg . "</span></a>";
            }
        }
        return $UrlStr;
    }

    //获取当前的URL，并对将要跳转的URL做修改
    //$Page将要跳转的页数
    function GetUrl($Page)
    {
        if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SERVER_NAME']) !== false) {
            $Url = $_SERVER['REQUEST_URI'];
        } else {
            if ($_SERVER['SERVER_PORT'] == 80) {
                $Url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            } else {
                $Url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
            }
        }
        //对url做修改，将url中的?page="任何字符" 或者 &page="任何字符" 替换成空
        $Url = preg_replace("/\?page=\w*/i", "", $Url);
        $Url = preg_replace("/&page=\w*/i", "", $Url);
        if ($Page === 0) {
            return $Url;
        }
        //判断先前是否已url传值，是则加&page=,否则加?page=
        if (preg_match("/\?/", $Url)) {
            $Url = $Url . "&page=" . $Page;
        } else {
            $Url = $Url . "?page=" . $Page;
        }
        $Url .= $this->anchor;
        return $Url;
    }

    //翻页效果，当前页保持前后$x页，如$x=2当前为5的话 1 2 ...3 4 5 6 7 ...8 9 
    function DisPageNum($x)
    {
        if (!isset($PageNumString)) $PageNumString = '';
        if ($x < 1) $x = 1;
        $fix = 1 + $x;
        $PNS = $leftPNS = $rightPNS = '';
        $pgo = $this->pgo;
        $pageBreak = "<span class=\"page-break {$pgo}\">...</span>";
        $Tpg = $this->TotalPage;
        $Npg = $this->NowPage;
        for ($i = $Npg - $x; $i <= $Npg + $x; $i++) {
            $PNS .= $this->ToPage($i, $i);
        }
        if ($Npg > $fix) {
            $cha = $Npg - $fix;
            for ($i = 1; $i <= $cha; $i++) {
                if ($i == $fix) {
                    $leftPNS .= $pageBreak;
                    break;
                }
                $leftPNS .= $this->ToPage($i, $i);
            }
        }
        $fix = $Tpg - $x;
        if ($Npg < $fix) {
            $cha = $fix - $Npg;
            for ($i = $Tpg - $cha + 1; $i <= $Tpg; $i++) {
                if ($fix > $i) {
                    $rightPNS = $pageBreak;
                } elseif ($fix != $i) {
                    $rightPNS .= $this->ToPage($i, $i);
                }
            }
        }
        $PageNumString = $leftPNS . $PNS . $rightPNS;
        return $PageNumString;
    }

}
