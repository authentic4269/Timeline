<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorCode = 0;
		$errorDescription = '';
		
		if (($id = Token::getId()) && (requirePostFields(array('parent', 'child'))))
		{
			$parent = $sqlController->esc($_POST['parent']);
			$child = $sqlController->esc($_POST['child']);
			$query = "INSERT INTO event_relationships('parent', 'child') VALUES(" . $parent . ", " . $child . ")";
			var_export($query);
			$result = $sqlController->query($query);
			$data = array('uploaded' => true);
		}
		else
		{
			setcookie('token', '');
			$data = array('uploaded' => false);
			$errorCode = 10;
			$errorDescription = 'Token is invalid';
		}
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorCode = 100;
		$errorDescription = $e->getMessage();
	}
	
	echo formResponse($data, $errorCode, $errorDescription);
?>