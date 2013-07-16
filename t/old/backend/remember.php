<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	ini_set('force_sender', $FROM_EMAIL);
	ini_set('sendmail_from', $FROM_EMAIL);
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		$id = NULL;
		
		Token::reset();
		
		if (isset($_POST['email']))
		{
			$email = $sqlController->esc($_POST['email'], false);
			
			$query = "SELECT id FROM users WHERE email='$email'";
			$result = $sqlController->query($query);
			
			if(count($result) == 0)
			{
				$data = array('remembered' => false);
				$errorObj = $errors->USER_NOT_FOUND;
			}
			else
			{
				$md5 = md5(time());
				$query = "UPDATE users SET confirm_string='$md5' WHERE email='$email'";
				$result = $sqlController->query($query);
				
				if($result)
				{
					$data = array('remembered' => true);
					
					$url = $_SERVER['REQUEST_URI'];
					$parts = explode('/',$url);
					$dir = $_SERVER['SERVER_NAME'];
					for ($i = 0; $i < count($parts) - 1; $i++) {
						$dir .= $parts[$i] . "/";
					}
					
					$confirmationLink = 'http://' . $dir . 'remind.php?code=' . $md5;
					
					$message = "
					<html>
						<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
							<title>Reset the password</title>
						</head>
						<body>
							<p>You have requested the password reset on Timeline Application</p>
							<p>Please follow the link below to change it:</p>
							<p>$confirmationLink</p>
							<br/>
							<br/>
							<p>If you didn't do that, just ignore this message.</p>
						</body>
					</html>
					";
					
					$headers = '';
					$headers .= "From: $FROM_EMAIL\r\n";
					//$headers .= 'Reply-To: user@yourdomain.com' . "\r\n";
					$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
					$headers .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8';
					
					mail($email, 'Reset the password', $message, $headers);
				}
			}
		}
		else
		{
			$data = array('remembered' => false);
			$errorObj = $errors->INCORRECT_EMAIL;
		}
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorObj = array('code' => 100, 'description' => $e->getMessage());;
	}
	
	echo formResponse($data, $errorObj);
?>