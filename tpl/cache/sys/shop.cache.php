<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/shop.html', '39fbac47fdc18a7ae702ea4a1750f450', 1438935821);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>城市柜台</title>
    <link rel="stylesheet" type="text/css" href="css/sys.css"/>
    <link rel="stylesheet" type="text/css" href="css/page.css"/>
    <script src="<?=JQ_URL?>" type="text/javascript"></script>
    <script src="<?=LIB_URL?>layer/layer.min.js" type="text/javascript"></script>
    <script src="js/sys.js" type="text/javascript"></script>
</head>

<body>
<div id="wrap">
    <h1>城市柜台列表</h1>
    <div class="list-tool">
        <form name="schForm" method="get">
            <input name="kw" class="inp" type="text" value="<?=$kw?>"/>
            <input class="btn" type="submit" value="搜索"/>
        </form>
    </div>
    <table id="list" class="list" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th width="80">ShopID</th>
            <th width="80">编号</th>
            <th width="120">柜台</th>
            <th width="300">柜台地址</th>
            <th width="50"></th>
            <th width="150">电话</th>
            <th width="100">城市</th>
            <th width="auto"></th>
        </tr>
        <? if(is_array($list)) { foreach($list as $k => $v) { ?>        <tr>
            <td><?=$v['ShopID']?></td>
            <td><?=$v['ShopCode']?></td>
            <td><?=$v['ShopName']?></td>
            <td><?=$v['ShopAddress']?></td>
            <td></td>
            <td><?=$v['ShopPhone']?></td>
            <td><?=$v['CityName']?></td>
            <td></td>
        </tr>
        <? } } ?>    </table>

    <?=$endpage?>
</div>
</body>
</html>
