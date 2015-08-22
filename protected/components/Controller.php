<?php
/**
* \View
*/
class View
{
  const VIEW_BASE_PATH = '/app/views/';

  public $view;
  public $data;

  public function __construct($view)
  {
    $this->view = $view;
  }

  public static function make($viewName = null)
  {
    if ( ! $viewName ) {
      throw new InvalidArgumentException("视图名称不能为空！");
    } else {

      $viewFilePath = self::getFilePath($viewName);
      if ( is_file($viewFilePath) ) {
        return new View($viewFilePath);
      } else {
        throw new UnexpectedValueException("视图文件不存在！");
      }
    }
  }

  public function with($key, $value = null)
  {
    $this->data[$key] = $value;
    return $this;
  }

  private static function getFilePath($viewName)
  {
    $filePath = str_replace('.', '/', $viewName);
    return BASE_PATH.self::VIEW_BASE_PATH.$filePath.'.php';
  }

  public function __call($method, $parameters)
  {
    if (starts_with($method, 'with'))
    {
      return $this->with(snake_case(substr($method, 4)), $parameters[0]);
    }

    throw new BadMethodCallException("方法 [$method] 不存在！.");
  }
}

/**
* 
*/
class Controller
{
	public function josn_success($value='')
	{
		echo json_encode(array('code' => 1, ));
		//exit;
	}
	
	public function beforeRender(){

	}

	public function render($view,$data = array()){

		header('Content-Type: text/html; charset=UTF-8');
		extract($data);
		include "./view/index.php";
	}
}