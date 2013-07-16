<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		if (isset($_COOKIE['token'])) {
			$token = htmlspecialchars($_COOKIE['token']);
			$result = $sqlController->query("SELECT u.username, ua.user_id FROM users u, users_auth ua WHERE u.id = ua.user_id AND ua.token =  '$token' AND expire > NOW()");
			
			if(count($result) < 1)
			{
				Token::reset();
				$data = array('logged_in' => false);
			}
			else {
				$id = $result[0]['user_id'];
				$username = $result[0]['username'];
				
				$data = array('logged_in' => true, 'username' => $username);
				
				$result = $sqlController->query("DELETE FROM users_auth WHERE user_id=$id AND expire <= NOW()");
			}
		}
		else{
			$data = array('logged_in' => false);
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