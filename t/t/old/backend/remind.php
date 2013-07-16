<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
			
		if (isset($_GET['code']))
		{
			$code = $sqlController->esc($_GET['code']);
			
			$query = "SELECT id FROM users WHERE confirm_string=$code";
			$result = $sqlController->query($query);
			
			if(count($result) != 0)
			{
				$md5 = md5(time());
				$query = "UPDATE users SET confirm_string='$md5' WHERE confirm_string=$code";
				
				$result = $sqlController->query($query);
				if($result)
				{
					setcookie('confirm', $md5);
					header( "Location: http://$DOMAIN#newPassword");
				}
			}
			else
			{
				header("Location: http://$DOMAIN");
			}
		}
		else if(isset($_COOKIE['confirm']) && isset($_POST['password']) && isset($_POST['repassword']))
		{
			$confirm = htmlspecialchars($_COOKIE['confirm']);
			$password = $sqlController->esc($_POST['password'], false);
			$repassword = $sqlController->esc($_POST['repassword'], false);
			
			if(strcmp($password, $repassword) != 0)
			{
				$data = array('changed' => false);
				$errorObj = $errors->PASSWORDS_NOT_MATCH;
			}
			else
			{
				setcookie('confirm', '');
				
				$query = "SELECT id, username, confirmed FROM users WHERE confirm_string='$confirm'";
				$result = $sqlController->query($query);
				
				if(count($result) == 0)
				{
					$data = array('changed' => false);
					$errorObj = $errors->USER_NOT_FOUND;
				}
				else
				{
					$id = $result[0]['id'];
					$username = $result[0]['username'];
					$confirmed = $result[0]['confirmed'];
					
					$encryptedPass = md5($password);
					
					$query = "UPDATE users SET password='$encryptedPass', confirm_string='' WHERE confirm_string='$confirm'";
					$result = $sqlController->query($query);
					
					if($result)
					{
						if(!$confirmed)
						{
							$data = array('changed' => false);
							$errorObj = $errors->ACCOUNT_NOT_CONFIRMED;
						}
						else
						{
							Token::set($id);
							$data = array('changed' => true, 'username' => $username);
						}
					}
					else
					{
						$data = array('changed' => false);
						$errorObj = $errors->CONFIRMATION_CODE_INVALID;
					}
				}
			}
		}
		else
		{
			$data = array('changed' => false);
			$errorObj = $errors->PARAMETERS_REQUIRED;
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