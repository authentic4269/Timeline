<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		$id = NULL;
		
		if (($user_id = Token::getId()) && (isset($_POST['id'])))
		{
			$id = $_POST['id'];	
			$result = $sqlController->query("DELETE FROM projects WHERE user_id=$user_id AND id=$id");
			$data = array('deleted' => true, 'projects' => $result);
		}
		else if (!isset($_POST['id']))
		{
			$data = array('deleted' => false);
			$errorObj = $errors->PARAMETERS_REQUIRED;
		}
		else
		{
			Token::reset();
			$data = array('deleted' => false);
			$errorObj = $errors->INVALID_TOKEN;
		}
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorObj = array('code' => 100, 'description' => $e->getMessage());
	}
	
	echo formResponse($data, $errorObj);
?>