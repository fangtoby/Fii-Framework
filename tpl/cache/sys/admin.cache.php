<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/admin.html', '7ff1b2ecb378b98f9ce9e1b5064765a0', 1438935822);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>管理员</title>
    <link rel="stylesheet" type="text/css" href="css/sys.css"/>
    <link rel="stylesheet" type="text/css" href="css/page.css"/>
    <script src="<?=JQ_URL?>" type="text/javascript"></script>
    <script src="<?=LIB_URL?>layer/layer.min.js" type="text/javascript"></script>
    <script src="js/sys.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            //保存管理员
            $("#saveAdmin").click(function () {
                var username = $.trim($("#username").val());
                var password = $("#password").val();
                var admin_id = $("#admin_id").val();
                if (username) {
                    if (admin_id == 0 && $.trim(password) == '') {
                        msg('密码必须填写！');
                    } else {
                        $.post("admin.php", {act: 'save', admin_id: admin_id, username: username,password: password},
                            function (data) {
                                if (data == 1) window.location.reload();
                                else if (data == 2) msg('帐号已存在！请换个');
                                else msg('保存失败！');
                            }
                        );
                    }
                } else msg('帐号必须填写！');
            });
        });
        function del(id){
            if (confirm('确定删除此帐号吗？')) {
                $.post('admin.php',{act:'del', id:id}, function(data){
                    window.location.reload();
                });
            }
        }
        //创建或修改管理员
        function doAdmin(id){
            var tit = "创建管理员";
            if (id > 0) {
                tit = "修改管理员";
                var username = $("#edit_"+id).text();
                $(".red").show();
                $('#admin_id').val(id);
                $('#username').val(username);
            } else {
                $(".red").hide();
                $('#admin_id').val('0');
                $('#username').val('');
            }
            myLayer('#adminDiv', tit, 1, ['400px','250px'], 998);
        }
    </script>
</head>

<body>
<div id="wrap">
    <h1>管理员列表</h1>
    <div class="list-tool">
        <form name="schForm" method="get">
            <input name="kw" class="inp" type="text" value="<?=$kw?>"/>
            <input class="btn" type="submit" value="搜索"/> &nbsp;
            <a href="javascript: doAdmin(0);">+ 创建管理员</a>
        </form>
    </div>
    <table id="list" class="list" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th width="80">ID</th>
            <th width="120">管理员</th>
            <th width="160">创建时间</th>
            <th width="160">登录时间</th>
            <th width="auto">操作</th>
        </tr>
        <? if(is_array($list)) { foreach($list as $k => $v) { ?>        <tr>
            <td><?=$v['admin_id']?></td>
            <td id="edit_<?=$v['admin_id']?>"><?=$v['username']?></td>
            <td><?=$v['create_time']?></td>
            <td><?=$v['login_time']?></td>
            <td><a href="javascript: doAdmin('<?=$v['admin_id']?>');">修改</a>
                <? if($v['admin_id']>1001) { ?>
                | <a href="javascript:del(<?=$v['admin_id']?>);">删除</a>
                <? } ?>
            </td>
        </tr>
        <? } } ?>    </table>

    <?=$endpage?>
</div>
<div id="adminDiv" style="margin: 20px 0 0 20px;display:none;">
    <table class="row" border="0" cellspacing="0" cellpadding="0">
        <col width="60"/><col width="auto"/>
        <tr>
            <td>帐号：</td>
            <td><input id="username" type="text" value="" class="inp"></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input id="password" type="password" value="" class="inp"> <span class="red">密码不修改请留空</span></td>
        </tr>
        <tr><td></td><td>
            <input id="admin_id" type="hidden" value="">
            <input class="btn" id="saveAdmin" type="button" value="保存"/>
            <input class="btn close" style="margin-left: 10px;" type="button" value="取消" />
        </td>
        </tr>
    </table>
</div>
</body>
</html>
