<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/left.html', '6dd80e1ef7a74118291eb5b80d488119', 1438935771);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>leftFrame</title>
<style type="text/css">
body { background-color: #e9edee; font: 12px Arial; margin: 0; padding: 0;}
dl { margin: 15px 0; padding: 0;}
dt { color: #99a9ac; font: 12px Arial; height: 30px; line-height: 30px; padding-left: 24px; margin-bottom: 5px;}
dd { margin: 0; padding: 0;}
dd a {color: #46525e; display: block; height: 40px; font: 14px Arial; outline: none; text-decoration: none;}
.menu { padding-left: 24px; line-height: 40px;}
.menu:hover { padding-left: 21px; background-color: #d3dadc; border-left: 3px solid #16A085;}
.fixed { padding-left: 21px; line-height: 40px; background-color: #d3dadc; border-left: 3px solid #16A085;}
</style>
<script src="<?=JQ_URL?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("dd a").click(function(){
        $(".fixed").removeClass('fixed').addClass('menu');
        $(this).removeClass('menu').addClass('fixed');
    });
});
</script>
<base target="mainframe"/>
</head>

<body>

<dl>
    <dt>管理菜单</dt>
    <dd><a class="fixed" href="activity_record.php">活动参与记录</a></dd>
    <dd><a class="menu" href="activity_record.php?act=win">活动中奖记录</a></dd>
    <dd><a class="menu" href="shop.php">城市柜台列表</a></dd>
    <dd><a class="menu" href="sms_test.php">短信发送测试</a></dd>
    <dd><a class="menu" href="admin.php">管理员列表</a></dd>
</dl>

</body>
</html>
