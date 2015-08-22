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
		$this->josn_success();
		echo "IndexController index action";
	}
}