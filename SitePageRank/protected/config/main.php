<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'高應大網站資訊統計系統',
	'theme'=>'bootstrap',
	'language'=>'zh_TW',
	//'defaultController' => 'Data/rank', 


	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'cc123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		 'urlManager'=>array(
		 	'urlFormat'=>'path',
			'rules'=>array(
				'Getjsonbyid/<id:\d+>'=> 'Data/Getjsonbyid/',
				'Getjson'=> 'Data/Getjson',
				'getjsonhistrory/<id:\d+>'=> 'Data/GetJsonHistory/',
				
				'排名'   => 'Data/Rank',
				'行政單位排名'   => 'Data/RankOffice',
				'學術單位排名'   => 'Data/RankTeach',
				
				'排名/getJsonDetailbyid/<id:\d+>' => 'Data/getJsonDetailbyid/',
				'行政單位排名/getJsonDetailbyid/<id:\d+>' => 'Data/getJsonDetailbyid/',
				'學術單位排名/getJsonDetailbyid/<id:\d+>' => 'Data/getJsonDetailbyid/',


				'排名/Detail/<id:\d+>' => 'Data/Detail/',
				'行政單位排名/Detail/<id:\d+>' => 'Data/Detail/',
				'學術單位排名/Detail/<id:\d+>' => 'Data/Detail/',
				
				'排名/Getjson' => 'Data/Getjson',
				'行政單位排名/Getjson' => 'Data/GetOfficejson',
				'學術單位排名/Getjson' => 'Data/GetTeachjson',
				
				'排名/Getjsonbyid/<id:\d+>' => 'Data/Getjsonbyid/',
				'學術單位排名/Getjsonbyid/<id:\d+>' => 'Data/GetTeachJsonbyid/',
				'行政單位排名/Getjsonbyid/<id:\d+>' => 'Data/GetOfficeJsonbyid/',
				
				'cron/<key>'=>'Run/GetData/',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		//資料庫連線設定 
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=kuasGoogleInf',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '12345',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//管理者信箱
		'adminEmail'=>'wishnoblog@gmail.com',
		//管理者登入帳號密碼
		'adminUsername'=>'admin',
		'adminPassword'=>'admin',
		//學校的名字
		'schoolName'=>'高應大',
		//學校的網址
		'schoolURL'=>'http://www.kuas.edu.tw',
		//執行資料抓取時候，要附加的KEY，務必到下列網址產生，產生時候不要包含特殊符號
		//https://strongpasswordgenerator.com/
		'runKey'=>'0OY6478Xl29695l649Ni',
		'curl_proxy'=>false,
		//要模擬的UserAgent ,可以直接用瀏覽器開啓 http://www.whatsmyuseragent.com/ 取得
		'userAgent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:31.0) Gecko/20100101 Firefox/31.0',
	),
);