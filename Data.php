<?php

//静态文件服务器

define('STATIC_FILE_TRUE_SERVER', "www.fly.cc");

if (STATIC_FILE_TRUE_SERVER != $_SERVER['HTTP_HOST']) {

	define('STATIC_FILE_SERVER',STATIC_FILE_TRUE_SERVER);	

}else{

	define('STATIC_FILE_SERVER', $_SERVER['HTTP_HOST']);

}

//静态文件目录

define('REQUEST_PATH_STATIC', "http://" . STATIC_FILE_SERVER . '/public/');

//javascript

define('REQUEST_PATH_STATIC_JS', REQUEST_PATH_STATIC . 'js/');

//stylesheet

define('REQUEST_PATH_STATIC_CSS', REQUEST_PATH_STATIC . 'css/');

//iamges 

define('REQUEST_PATH_STATIC_IMG', REQUEST_PATH_STATIC . 'images/');

/**
*
* 常用数据、连接、集合封装类
*
*/
class Data
{
	
	static public $data = array();

	/*
	*	生成静态文件路径
	*	包含文件版本控制
	*	支持图片属性添加
	*	支持css,js,images
	*
	*	@usage:
	*	
	*	创建基于本项目的静态文件
	*	
	*	<?=Fii::app()->getStaticUri('js','app.js')?>;
	*
	*	<script type="text/javascript" src="http://www.fly.cc/public/js/app.js"></script>
	*
	*	创建基于外部引用的静态文件
	*
	*	<?=Fii::app()->getStaticUri('js','http://code.jquery.com/jquery-1.4.1.min.js')?>;
	*	
	*	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
	*
	*	添加属性	
	*
	*	<?=Fii::app()->getStaticUri('images','loadinfo.gif',array('class'=>'load_img'))?>
	*	
	*	<img src="http://www.fly.cc/public/images/loadinfo.gif" alt="" class="load_img">
	*
	*	@todo: 
	*		1.添加版本控制，缓存处理，
	*		2.添加自定义属性
	*/

	public function elementDomCreate($type, $name , $attribute = NULL , $cash = false)
	{
		$staticUri = '';
		$tagSign = '__TAG__';
		$attrSign = '__ATTRIBUTE__';
		$httpSource = 'http://';

		$addFix = false;

		if (strstr($name, $httpSource)) {
			$addFix = true;	
		}
		
		$typeArr = array(
			0=>'css',
			1=>'js',
			2=>'images'
		);

		$staticUriArr = array(
			'images' =>'<img src="__TAG__" alt="" __ATTRIBUTE__ >', 
			'js' => '<script type="text/javascript" src="__TAG__" __ATTRIBUTE__ ></script>', 
			'css' => '<link type="text/css" rel="stylesheet" href="__TAG__" __ATTRIBUTE__ >', 
		);


		switch ($type) {
			case $typeArr[0]:
				$name = $addFix ? $name:REQUEST_PATH_STATIC_CSS . $name;
				$staticUri = str_replace($tagSign , $name , $staticUriArr['css']);
				break;
			case $typeArr[1]:
				$name = $addFix ? $name:REQUEST_PATH_STATIC_JS . $name;
				$staticUri = str_replace($tagSign , $name , $staticUriArr['js']);
				break;
			case $typeArr[2]:
				$name = $addFix ? $name:REQUEST_PATH_STATIC_IMG . $name;
				$staticUri = str_replace($tagSign , $name , $staticUriArr['images']);
				break;
		}

		$attributeStr = '';

		// array('class'=>'loaded', 'width'=>'300px' ,...)

		if (is_array($attribute)) {
			foreach ($attribute as $key => $value) {
				$attributeStr .= $key . ' ="' . $value . '"';
			}
		}
		
		$staticUri = str_replace($attrSign, $attributeStr, $staticUri);

		return $staticUri;
	}
	
}

Data::$data['static_path'] = array( 
	'public' => REQUEST_PATH_STATIC,
	'js' => REQUEST_PATH_STATIC_JS ,
	'css' => REQUEST_PATH_STATIC_CSS ,
	'images' => REQUEST_PATH_STATIC_IMG ,
);

Data::$data['config'] = require(dirname(__FILE__).'/protected/config/main.php');


/**
* Fii App Class Main
*	
* Fii::app()
*
*/
class Fii extends Data
{
	public static function app()
	{
		return new Fii();
	}

	public function staticUri($value='')
	{
		return Data::$data['static_path'];
	}
}