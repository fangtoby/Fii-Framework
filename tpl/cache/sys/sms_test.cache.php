<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/sms_test.html', '1a88b695206db14ded38b5ff5406c146', 1438935821);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk"/>
    <title>���ŷ��Ͳ���</title>
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
                    msg('����д�ֻ�����Ͷ������ݣ�');
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
    <h1>���ŷ��Ͳ���</h1>
    <form id="smsForm" method="post" action="<?=$sms['action']?>">
        <table class="row" border="0" cellpadding="0" cellspacing="0">
            <col width="120"><col width="auto">
            <tr>
                <td>���ͷ�ʽ��</td>
                <td>POST</td>
            </tr>
            <tr>
                <td>���͵�ַ��</td>
                <td><?=$sms['action']?></td>
            </tr>
            <tr>
                <td>�����ʺţ�</td>
                <td><input class="inp w400" name="uid" value="<?=$sms['uid']?>"/></td>
            </tr>
            <tr>
                <td>�������룺</td>
                <td><input class="inp w400" name="pwd" value="<?=$sms['pwd']?>"/></td>
            </tr>
            <tr>
                <td>�ֻ����룺</td>
                <td><input class="inp w400" id="mobile" name="mobile" value=""/>
                <p class="gray">POST�ӿ�Ŀǰֻ֧��1000�����룬�Էֺš�;���ָ�</p></td>
            </tr>
            <tr>
                <td>�������ݣ�</td>
                <td><input class="inp w400" id="msg" name="msg" value="<?=$sms['msg']?>"/></td>
            </tr>
            <tr>
                <td>����ʱ�䣺</td>
                <td><input class="inp w400" name="dtime" value=""/>
                    <p class="gray">ʱ��Ϊ������������, ��ʽ:2015-08-01 00:00:00</p></td>
            </tr>
            <tr>
                <td>��ֵ˵����</td>
                <td><p class="gray">0���ͳɹ�!; 1�û������������!; 2����!; 3�������������1000��;
                    <br>4���û�����������!; 5�ֻ��Ż�����Ϣ����Ϊ��!</p></td>
            </tr>
            <tr>
                <td></td>
                <td><br><input class="btn w100" type="submit" value="���Ͷ���"/></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>