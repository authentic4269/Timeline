<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		$id = NULL;
		
		if($id = Token::getId())
		{
			$user_id = (isset($_POST['userId'])) ? $sqlController->esc($_POST['userId']) : $id;
			
			$result = $sqlController->query("SELECT id, title, link, created, last_modified FROM projects WHERE user_id=$user_id");
			
			$data = array('fetched' => true, 'projects' => $result);
		}
		else
		{
			Token::reset();
			$data = array('fetched' => false);
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