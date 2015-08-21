<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/activity_record.html', '8ca661f175c54bc3309ac412a46d6e60', 1438935771);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>活动记录</title>
    <link rel="stylesheet" type="text/css" href="css/sys.css"/>
    <link rel="stylesheet" type="text/css" href="css/page.css"/>
    <script src="<?=JQ_URL?>" type="text/javascript"></script>
    <script src="<?=LIB_URL?>layer/layer.min.js" type="text/javascript"></script>
    <script src="js/sys.js" type="text/javascript"></script>
</head>

<body>
<div id="wrap">
    <h1>
        <? if($act=='win') { ?>活动中奖记录
        <? } else { ?>活动参与记录
        <? } ?>
    </h1>
    <div class="list-tool">
        <form name="schForm" method="get">
            <input name="kw" class="inp" type="text" value="<?=$kw?>"/>
            <input class="btn" type="submit" value="搜索"/> &nbsp;&nbsp;
            <a href="<?=SITE_URL?>sys/export.php" target="_blank">+ 导出全部</a> &nbsp;&nbsp;
            <a href="<?=SITE_URL?>sys/export.php?type=1" target="_blank">+ 导出已中奖</a> &nbsp;&nbsp;
            <a href="<?=SITE_URL?>sys/export.php?type=2" target="_blank">+ 导出未中奖</a>
        </form>
    </div>
    <table id="list" class="list" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th width="150">手机</th>
            <th width="120">城市</th>
            <th width="150">柜台</th>
            <th width="160">参与时间</th>
            <th width="100">参与次数</th>
            <th width="100">是否中奖</th>
            <th width="auto"></th>
        </tr>
        <? if(is_array($list)) { foreach($list as $k => $v) { ?>        <tr>
            <td><?=$v['mobile']?></td>
            <td><?=$v['CityName']?></td>
            <td><?=$v['ShopName']?></td>
            <td><?=$v['join_time']?></td>
            <td><?=$v['join_cnt']?></td>
            <td><? if($v['win']==1) { ?><span class="red">中奖</span><? } ?></td>
            <td></td>
        </tr>
        <? } } ?>    </table>

    <?=$endpage?>
</div>
</body>
</html>
