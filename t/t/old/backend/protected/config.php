<?php
	error_reporting(E_ALL);
	
	$HOST = 'localhost';
	$PORT = '3306';
	$DB_NAME = 'c11_timeline';
	$USER = 'c11_timeline';
	$PASSWORD = 'x102030!';
	
	$DOMAIN = 'timeline.mgrnix.com';
	$FROM_EMAIL = 'registration@timeline.com';
	
	require_once('protected/db.php');
	require_once('protected/service_func.php');
	require_once('protected/token.php');
	require_once('protected/errors.php');
?>