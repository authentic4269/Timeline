<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Timeline',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'giipass',
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
		'mail' => array(
				'class' => 'ext.yii-mail.YiiMail',
				'transportType'=>'smtp',
				'transportOptions'=>array(
					'encryption'=>'tls',
					'host'=>'smtp.gmail.com',
					'username'=>'timelineappmailer', //email username w/o @gmail.com	
					'password'=>'x102030!
							', //email pass
					'port'=>'465',
				),
				'viewPath' => 'application.views.mail',
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'caseSensitive'=>false,
			'rules'=>array(
				array('site/namecheck', 'pattern'=>'site/namecheck', 'verb'=>'POST'),
				array('site/login', 'pattern'=>'site/login', 'verb'=>'POST'),
				array('site/logout', 'pattern'=>'site/logout', 'verb'=>'POST, GET'),
				array('site/register', 'pattern'=>'u/register', 'verb'=>'POST'), 
				array('site/rememberUser', 'pattern'=>'site/remember', 'verb'=>'GET, POST'),
				array('site/confirm', 'pattern'=>'confirm/<st:[\d\w]+>', 'verb'=>'GET'),
				array('project/view', 'pattern'=>'api/project/<id:\d+>', 'verb'=>'GET'),
				array('project/lines', 'pattern'=>'api/project/lines', 'verb'=>'POST'),
				array('project/events', 'pattern'=>'api/project/events', 'verb'=>'POST'),
				array('project/listMine', 'pattern'=>'api/project/mine', 'verb'=>'GET'),
				array('project/listAll', 'pattern'=>'api/project/all', 'verb'=>'GET'),
				array('project/tag', 'pattern'=>'api/project/tag', 'verb'=>'POST'),
				array('project/deletetag', 'pattern'=>'api/project/deletetag', 'verb'=>'POST'),
				array('project/create', 'pattern'=>'api/project/create', 'verb'=>'POST'),
				array('project/delete', 'pattern'=>'api/project/delete', 'verb'=>'POST'),
				array('project/update', 'pattern'=>'api/project/update', 'verb'=>'POST'),
				array('project/addLine', 'pattern'=>'api/project/addLine', 'verb'=>'POST'),
				array('project/deleteLine', 'pattern'=>'api/project/deleteLine', 'verb'=>('POST')),
				array('line/view', 'pattern'=>'api/line/<id:\d+>', 'verb'=>'GET'),
				array('line/list', 'pattern'=>'api/line/list', 'verb'=>'GET'),
				array('line/create', 'pattern'=>'api/line/create/', 'verb'=>'POST'),
				array('line/delete', 'pattern'=>'api/line/delete', 'verb'=>'POST'),
				array('line/tag', 'pattern'=>'api/line/tag', 'verb'=>'POST'),
				array('line/update', 'pattern'=>'api/line/update', 'verb'=>'POST'),
				array('line/addEvent', 'pattern'=>'api/line/addEvent', 'verb'=>'POST'),
				array('line/deleteEvent', 'pattern'=>'api/line/deleteEvent', 'verb'=>('POST')),
				array('event/view', 'pattern'=>'api/event/<id:\d+>', 'verb'=>'GET'),
				array('event/list', 'pattern'=>'api/event/list', 'verb'=>'GET'),
				array('event/tag', 'pattern'=>'api/event/tag', 'verb'=>'POST, GET'),
				array('event/create', 'pattern'=>'api/event/create', 'verb'=>'POST'),
				array('event/delete', 'pattern'=>'api/event/delete', 'verb'=>'POST'),
				array('event/update', 'pattern'=>'api/event/update', 'verb'=>'POST'),
				array('event/addResource', 'pattern'=>'api/event/addResource', 'verb'=>'POST'),
				array('event/deleteResource', 'pattern'=>'api/event/add', 'verb'=>('POST')),
				array('resource/view', 'pattern'=>'api/resource/<id:\d+>', 'verb'=>'GET'),
				array('resource/tag', 'pattern'=>'api/resource/tag', 'verb'=>'POST'),
				array('resource/list', 'pattern'=>'api/resource/list', 'verb'=>'GET'),
				array('resource/create', 'pattern'=>'api/resource/create', 'verb'=>'POST'),
				array('resource/delete', 'pattern'=>'api/resource/delete', 'verb'=>'POST'),
				array('resource/update', 'pattern'=>'api/resource/update', 'verb'=>'POST'),
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=c11_timeline',
			'emulatePrepare' => true,
			'username' => 'root', //c11_timeline
			'password' => '', //x102030!
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
				/* uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),*/
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'ERR_LOGIN_MESSAGE'=>'You are not currently logged in',
		'ERR_AUTH_MESSAGE'=>'You do not have authorization to access this resource',
		'ERR_DNE_MESSAGE'=>'The requested resource does not exist',
		'ERR_PARAMS_MESSAGE'=>'Paramater not allowed: ',
		'ERR_SAVE_MESSAGE'=>'There was an error saving: ',
		'ERR_DB_MESSAGE'=>'There was a database error',
		'ERR_LOGIN_MESSAGE'=>'There was an error logging in',
		'ERR_INVALID_MESSAGE'=>'There was an error with your username or password',
		'ERR_REGISTER_MESSAGE'=>'There was an error registering you',
		'RESOURCE_DIR'=>'./resources/',
		'ERR_LOGIN_CODE'=>1,
		'ERR_AUTH_CODE'=>2,
		'ERR_DNE_CODE'=>3,
		'ERR_PARAMS_CODE'=>4,
		'ERR_SAVE_CODE'=>5,
		'ERR_DB_CODE'=>6,
		'ERR_LOGIN_CODE'=>7,
		'ERR_INVALID_CODE'=>8,
		'ERR_REGISTER_CODE'=>9,
		'OWNER'=>0,
		'VIEWER'=>1,
		'NO_ACCESS'=>2,
	),
);
