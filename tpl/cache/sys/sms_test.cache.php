<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/sms_test.html', '1a88b695206db14ded38b5ff5406c146', 1438935821);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk"/>
    <title>短信发送测试</title>
    <link rel="stylesheet" type="text/css" href="css/sys.css"/>
    <script src="<?=JQ_URL?>" type="text/javascript"></script>
    <script src="<?=LIB_URL?>layer/layer.min.js" type="text/javascript"></script>
    <script src="js/sys.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $("#smsForm").submit(function () {
                var mobile = $.trim($("#mobile").val());
                var smsMsg = $.trim($("#msg").val());
                if (!mobile || !smsMsg) {
                    msg('请填写手机号码和短信内容！');
                    $("#mobile").focus();
                    return false;
                }
                return true;
            });
        });
    </script>
</head>

<body>
<div id="wrap">
    <h1>短信发送测试</h1>
    <form id="smsForm" method="post" action="<?=$sms['action']?>">
        <table class="row" border="0" cellpadding="0" cellspacing="0">
            <col width="120"><col width="auto">
            <tr>
                <td>发送方式：</td>
                <td>POST</td>
            </tr>
            <tr>
                <td>发送地址：</td>
                <td><?=$sms['action']?></td>
            </tr>
            <tr>
                <td>短信帐号：</td>
                <td><input class="inp w400" name="uid" value="<?=$sms['uid']?>"/></td>
            </tr>
            <tr>
                <td>短信密码：</td>
                <td><input class="inp w400" name="pwd" value="<?=$sms['pwd']?>"/></td>
            </tr>
            <tr>
                <td>手机号码：</td>
                <td><input class="inp w400" id="mobile" name="mobile" value=""/>
                <p class="gray">POST接口目前只支持1000个号码，以分号“;”分隔</p></td>
            </tr>
            <tr>
                <td>短信内容：</td>
                <td><input class="inp w400" id="msg" name="msg" value="<?=$sms['msg']?>"/></td>
            </tr>
            <tr>
                <td>发送时间：</td>
                <td><input class="inp w400" name="dtime" value=""/>
                    <p class="gray">时间为空则立即发送, 格式:2015-08-01 00:00:00</p></td>
            </tr>
            <tr>
                <td>返值说明：</td>
                <td><p class="gray">0发送成功!; 1用户名或密码错误!; 2余额不足!; 3超过发送最大量1000条;
                    <br>4此用户不允许发送!; 5手机号或发送信息不能为空!</p></td>
            </tr>
            <tr>
                <td></td>
                <td><br><input class="btn w100" type="submit" value="发送短信"/></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
