<?php
	require_once('protected/config.php');
	
	if (isset($_GET['code']))
	{
		$code = $sqlController->esc($_GET['code']);
		
		$query = "SELECT id, username FROM users WHERE confirm_string=$code";
		$result = $sqlController->query($query);
		
		if(count($result) == 1)
		{
			$id = $result[0]['id'];
			$username = intval($result[0]['username']);
			
			$token = md5(uniqid('', true).$username);
			setcookie('token', $token, time() + 60 * 60 * 24);
			
			$query = "INSERT INTO users_auth(user_id, token, expire) VALUES ($id,'$token',DATE_ADD(NOW(), INTERVAL 1 DAY))";
			$result = $sqlController->query($query);
			
			$query = "UPDATE users SET confirmed=1, confirm_string='' WHERE confirm_string=$code";
			$result = $sqlController->query($query);
			if($result)
			{
				header( "Location: http://$DOMAIN#confirmed" );
			}
		}
	}
?>