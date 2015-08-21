<?php
/**
* 
*/
class Controller
{
	public function josn_success($value='')
	{
		echo json_encode($array('code' => 1, ));
		exit;
	}
	
}