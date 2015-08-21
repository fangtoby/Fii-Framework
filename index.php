
<?php

//错误等级

//ini_set('display_errors', 'off');

//时区设置

ini_set('date.timezone','Asia/Shanghai');

//开发、上线参数

defined('ENV_DEBUG') or define('ENV_DEBUG',true);


define('PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$config = PATH_ROOT . 'protected/config/main.php';

require_once( 'Data.php' );


// echo $_SERVER['HTTP_HOST']."<br>";

// echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";

// echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];



// echo Fii::app()->elementDomCreate('css','main.css');

// //创建基于 本项目的静态文件

// echo Fii::app()->elementDomCreate('js','app.js');

// //创建基于 外部引用的静态文件

// echo Fii::app()->elementDomCreate('js','http://code.jquery.com/jquery-1.4.1.min.js');

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Fii App Framework</title>
	<?=Fii::app()->elementDomCreate('css','main.css')?>
	<script type="text/javascript">
		var star_time = (new Date()).getTime();
	</script>
</head>
<body>
	<div id="page_loading"><?=Fii::app()->elementDomCreate('images','loadinfo.gif',array('class'=>'load_img'))?></div>
	<div class="main">
		<h1>Fii App</h1>
		<h4>Hi. I am Fii</h4>
		<span><b>Author:</b>Fly</span>
	</div>

<?=Fii::app()->elementDomCreate('js','app.js')?>
<?=Fii::app()->elementDomCreate('js','http://code.jquery.com/jquery-1.4.1.min.js')?>

<script type="text/javascript">
	$(function(){
		$('.main').fadeIn(100,function(argument) {
			$('#page_loading').fadeOut();
		});
		console.log((new Date()).getTime() - star_time)
	});

</script>
</body>
</html>
