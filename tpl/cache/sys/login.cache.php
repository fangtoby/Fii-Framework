<? if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('sys/login.html', '76e1e0e02315cc0e2bc951f8098c2b96', 1438935610);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$cfgSite['title']?>活动管理后台</title>
    <style type="text/css">
        body{background-color: #f3f3f3;}
        body,h3,p {margin: 0; padding: 0; font:14px "Helvetica Neue","Microsoft YaHei","SimHei";}
        .ht{ font-family: "Helvetica Neue","Microsoft YaHei","SimHei";}
        #login{width: 300px; margin: 80px auto;}
        #login h3{font-size: 26px; font-weight: normal;letter-spacing: 3px;text-align: center;}
        #login p{position: relative; margin-top: 20px;}
        #login p span{ position:absolute; color: #333; top:12px; left: 15px; cursor: text;}
        #login p img{ position:absolute; cursor: pointer; top:2px; right: 2px;}
        #login p .text{width:100%; margin: 0; padding: 11px 15px 11px 75px;
            border: 1px solid #bebebe; color: #666; box-sizing: border-box; font-size: 14px;}
        #login p .submit{ position:absolute;width:100px; height:36px;border: 0;font-size: 14px;
            background-color: #555;color: #fff; cursor: pointer;top: 0; right: 0;}
    </style>
    <script src="<?=JQ_URL?>" type="text/javascript"></script>
    <script type="text/javascript">
        function checkLogin(){
            var user = $.trim($("#user").val());
            var pass = $.trim($("#pass").val());
            //var code = $.trim($("#code").val());
            var autoLogin = $("#autoLogin").val();
            if(!user){ alert('请输入帐号'); $("#user").focus(); return false;}
            if(!pass){ alert('请输入密码'); $("#pass").focus(); return false;}
            //if(!code){ alert('请输入验证码'); $("#code").focus(); return false;}
            $.post("index.php",{act:'login', user:user, pass:pass, autoLogin:autoLogin},
                function(data){
                    if(data == 'ok') window.location.href='index.php';
                    //else if(data == 2) alert('验证码错误！');
                    else alert('账号或密码错误！');
                }
            );
            return false;
        }
    </script>
</head>

<body>
    <div id="login">
        <form id="loginForm" name="loginForm" method="post" action="" onsubmit="return checkLogin();">
            <h3><?=$cfgSite['title']?>活动管理后台</h3>
            <p>
                <span>账 &nbsp; 号：</span>
                <input class="text ht" id="user" name="user" type="text" tabindex="1" autocomplete="off" autofocus />
            </p>
            <p>
                <span>密 &nbsp; 码：</span>
                <input class="text ht" id="pass" name="pass" type="password" tabindex="2" autocomplete="off" />
            </p>
            <!--
            <p>
                <span>验证码：</span>
                <input class="text ht" id="code" name="code" type="text" tabindex="3" maxlength="4" autocomplete="off"/>
                <img title="刷新验证码" alt="刷新验证码" src="<?=LIB_URL?>captcha/captcha.php"
                      onclick="this.src='<?=LIB_URL?>captcha/captcha.php?'+Math.random();"/>
            </p>-->
            <p style="color: #666;padding-top: 10px;">
                <label><input id="autoLogin" type="checkbox" value="1"/> 下次自动登录</label>
                <input class="submit ht" type="submit" value="登 录" tabindex="4"/>
            </p>
        </form>
    </div>
</body>
</html>