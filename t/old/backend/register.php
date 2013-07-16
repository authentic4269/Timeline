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
		
		Token:reset();
		
		if (requirePostFields(array('email', 'firstName', 'lastName', 'username', 'password', 'repassword')))
		{
			$email = $sqlController->esc($_POST['email'], false);
			$firstName = $sqlController->esc($_POST['firstName']);
			$lastName = $sqlController->esc($_POST['lastName']);
			$username = $sqlController->esc($_POST['username']);
			$password = $sqlController->esc($_POST['password'], false);
			$repassword = $sqlController->esc($_POST['repassword'], false);
			
			$query = "SELECT id FROM users WHERE email='$email'";
			$result = $sqlController->query($query);
			
			if(count($result) != 0)
			{
				$data = array('registered' => false, 'field' => 'email');
				$errorObj = $errors->ALREADY_REGISTERED;
			}
			else
			{
				$query = "SELECT id FROM users WHERE username=$username";
				$result = $sqlController->query($query);
				
				if(count($result) != 0)
				{
					$data = array('registered' => false, 'field' => 'username');
					$errorObj = $errors->USERNAME_ALREADY_TAKEN;
				}
				else
				{
					if(strcmp($password, $repassword) != 0)
					{
						$data = array('registered' => false, 'field' => 'password');
						$errorObj = $errors->PASSWORDS_NOT_MATCH;
					}
					else
					{
						$encryptedPass = md5($password);
						$md5 = md5(time());
						
						$query = "INSERT INTO users(first_name, last_name, username, email, confirm_string, password) VALUES ($firstName, $lastName, $username, '$email', '$md5', '$encryptedPass')";
						$result = $sqlController->query($query);
						
						if($result)
						{
							$data = array('registered' => true);
							
							$url = $_SERVER['REQUEST_URI'];
							$parts = explode('/',$url);
							$dir = $_SERVER['SERVER_NAME'];
							for ($i = 0; $i < count($parts) - 1; $i++) {
								$dir .= $parts[$i] . "/";
							}
							
							$confirmationLink = 'http://' . $dir . 'confirm.php?code=' . $md5;
							
							$message = "
							<html>
								<head>
									<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
									<title>Please confirm your registration</title>
								</head>
								<body>
									<p>You have entered this email address as registration email on Timeline Application</p>
									<p>Please follow the link below to confirm it:</p>
									<p>$confirmationLink</p>
									<br/>
									<br/>
									<p>If you didn't registered on Timeline Application, just ignore this message.</p>
								</body>
							</html>
							";
							
							$headers = '';
							$headers .= "From: $FROM_EMAIL\r\n";
							$headers .= 'Reply-To: user@yourdomain.com' . "\r\n";
							$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
							$headers .= 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8';
							
							mail($email, 'Please confirm your registration', $message, $headers);
						}
					}
				}
			}
		}
		else
		{
			$data = array('registered' => false);
			$errorObj = $errors->INCORRECT_CREDENTIALS;
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