<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/top.html', '85ca597cb3c4949a8c01cf1628bccf15', 1438935771);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>topFrame</title>
<style type="text/css">
body { margin: 0; padding: 0;}
#head { height: 55px; border-bottom: 1px solid #cacaca;}
#head h1 { float: left; margin-left: 10px; height: 50px; font:22px "Helvetica Neue","Microsoft YaHei","SimHei"; }
#head .user { float: right; color: #666; font: 12px Arial; margin: 20px 20px 0 0;}
#head .user a { color: #666; text-decoration:none;}
#head .user a:hover {color:#333; text-decoration:underline;}
</style>
</head>

<body>
<div id="head">
    <h1><?=$cfgSite['title']?>活动管理后台</h1>
    <div class="user">
        欢迎你, <?=$sysName?>&nbsp; | &nbsp;<a href="./?act=logout" target="_top">退出</a>
    </div>
</div>
</body>
</html>