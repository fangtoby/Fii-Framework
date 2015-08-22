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

	public function staticUri()
	{
		return Data::$data['static_path'];
	}

	public function ApplicationInit($path){
		Data::$data['config'] = require_once($path);
		$this->init();
	}
	
	public function init(){
		Data::$data['static_path'] = array( 
			'public' => REQUEST_PATH_STATIC,
			'js' => REQUEST_PATH_STATIC_JS ,
			'css' => REQUEST_PATH_STATIC_CSS ,
			'images' => REQUEST_PATH_STATIC_IMG ,
		);
		//print_r( Data::$data);
		WebAppExtend::init()->includeExtendClass(Data::$data['config']['import']);
		WebApplication::init()->route();
	}

}

/**
* 
*/
class WebAppExtend
{
	public static function init()
	{
		return new WebAppExtend();
	}

	public function includeExtendClass($extendArr){

		foreach ($extendArr as $key => $value) {
			if (is_string($value)) {

				$path = $this->changeExtendDirSign('.', $value, 'application', 'protected');

				$files = $this->getFileListFromPath($path);

				foreach ($files as $key => $value) {
					require_once($value);
				}
			}
		}
	}

	public function changeExtendDirSign($sign, $str, $parentDirName, $nowDirName)
	{
		$path = str_replace($sign, DIRECTORY_SEPARATOR , $str);
		$pathStrLength = strlen($path);

		if ($path[ $pathStrLength - 1 ] === '*') {
			$path = substr($path,0, $pathStrLength - 1);
		}

		$path = str_replace($parentDirName, $nowDirName, $path);
		$path = PATH_ROOT . $path;
		return $path;
	}

	public function getFileListFromPath($path)
	{
		$filelist = array();

		if (is_dir($path)) {
			$files=scandir($path);
			if (count($files)) {
				foreach ($files as $key => $value) {
					if ($value != '.' && $value != '..') {
						$file = $path . $value;
						if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
							$filelist[] = $file;
						}
					}
					
				}
			}
		}
		return $filelist;
	}
}

/**
*	按照路由选择相应的控制器与方法 
*/

class WebApplication
{
	
	public static function init()
	{
		return new WebApplication();
	}

	public function route($value='')
	{
		$clsExt = 'Controller';
		$actExt = 'action';
		$rouNam = 'path';
		if ($_SERVER['REQUEST_URI'] != '') {
			$rparam = $this->parse_query($_SERVER['REQUEST_URI']);
		}else{
			throw new Exception("Error Processing Request", 1);
		}
		if (ENV_DEBUG) {
			print_r($rparam); 
		}
		if (isset( $rparam[ $rouNam ])) {
			$r = explode('/', strtolower( $rparam[ $rouNam ] ));
			if (is_array($r)) {
				switch (count($r)) {
					case 0:
						$this->reflectionAPI();
						break;
					case 1:
						$this->reflectionAPI( ucfirst($r[0]).$clsExt);
						break;
					case 2:
						$this->reflectionAPI( ucfirst($r[0]).$clsExt , $actExt.ucfirst($r[1]));
						break;
					case 3:
						$this->reflectionAPI( ucfirst($r[0]).$clsExt , $actExt.ucfirst($r[1]) , ucfirst($r[2]));
						break;
					//...
				}
			}else{
				throw new Exception("Error Processing Request", 1);
			}
			
		}else{
			throw new Exception("Error Processing Request", 1);
		}
	}
	// Originally written by xellisx
	public function parse_query($var)
	{
	  /**
	   *  Use this function to parse out the query array element from
	   *  the output of parse_url().
	   */
	  $var  = parse_url($var, PHP_URL_QUERY);
	  $var  = html_entity_decode($var);
	  $var  = explode('&', $var);
	  $arr  = array();

	  foreach($var as $val){
			$x= explode('=', $val);
	    	$arr[$x[0]] = $x[1];
	   }
	  unset($val, $x, $var);
	  return $arr;
	}

	public function reflectionAPI($controllerStr = 'IndexController', $actionStr = 'actionIndex' , $modulesStr = '')
	{
		if ($modulesStr != '') {
			$controllerPath = PATH_ROOT.'protected'.DIR_SIGN.'modules'.DIR_SIGN;
			$controllerPath .= $modulesStr.DIR_SIGN.'controller'.DIR_SIGN;
		}else{
			$controllerPath = PATH_ROOT.'protected'.DIR_SIGN.'controller'. DIR_SIGN;
		}

		$classPath = $controllerPath . $controllerStr .'.php';

		if (file_exists($classPath)) {
			require_once($classPath);	
		}else{
			throw new Exception("Error {$classPath} is not exsit.", 1);
		}

		$class = new ReflectionClass( $controllerStr );

		if ($class->hasMethod($actionStr)) {
			$instance  = $class->newInstanceArgs(); 
			$method = $class->getMethod($actionStr);
			if ($method->isPublic() && !$method->isStatic()) {
				$method->invoke($instance);
			}else{
				throw new Exception("{$actionStr} is private method", 1);
			}
		}else{
			throw new Exception("Error Processing Request", 1);
		}
	}	
}
