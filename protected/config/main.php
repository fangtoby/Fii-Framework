<?php

return array(
	//app name
	'appName' => 'Fly Web System',
	
	//Static File Sever domin
	'staticFileSever' => 'www.fly.cc' ,

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'db' => array(
			'mysql'=>array(
			    'host' => 'localhost',
			    'user' => 'aplotion_comeyes',
			    'pass' => 'yR2HV931tB',
			    'name' => 'aplotion_comeyes_cn'
	    	),
	    	//'sqlit'
	),

);