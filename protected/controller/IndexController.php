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
		$lineDateStr = '2015-09-01 00:00:00';
		$timeline = strtotime($lineDateStr);
		$timenow = time();

		if ($timenow > $timeline ) {
			echo 1;
		}else{
			echo 2;
		}
		$this->josn_success();
		echo "IndexController index action";
	}
}