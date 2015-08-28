<?php

/**
* 
*/
class IndexController extends Controller
{

	private function actionInit(){
		echo 2;
	}

	public function actionIndex()
	{
		
		// echo "This is " . __CLASS__ . " class.\n";
		// echo "This is " . __METHOD__ . " method.\n";
		// echo "This is function '" . __FUNCTION__ . "' inside class.\n";

		// echo "This is " . __FILE__  . " __FILE__ .\n";
		// echo "This is " . __DIR__  . " __DIR__ .\n";


		$this->josn_success();
	}
}