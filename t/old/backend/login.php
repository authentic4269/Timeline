<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		$banned = false;
		$id = NULL;
		
		if($id = Token::getId())
		{
			Token::refresh();
			
			$data = array('logged_in' => true);
		}
		else
		{
			if (requirePostFields(array('username', 'password')))
			//if (isset($_POST['username']) && isset($_POST['password']))
			{
				$username = $sqlController->esc($_POST['username']);
				$password = $sqlController->esc($_POST['password'], false);
				
				$encryptedPass = md5($password);
				
				$query = "SELECT id, confirmed FROM users WHERE username=$username AND password='$encryptedPass'";
				$result = $sqlController->query($query);
				
				if(count($result) < 1)
				{
					$data = array('logged_in' => false);
					$errorObj = $errors->INCORRECT_LOGIN_PASS;
				}
				else
				{
					$id = $result[0]['id'];
					$confirmed = $result[0]['confirmed'];
					
					if(!$confirmed)
					{
						$data = array('logged_in' => false);
						$errorObj = $errors->ACCOUNT_NOT_CONFIRMED;
					}
					else {
						Token::set($id);
						$data = array('logged_in' => true);
					}
				}
			}
			else
			{
				$data = array('logged_in' => false);
				$errorObj = $errors->PARAMETERS_REQUIRED;
			}
		}
		
		if($id)
			Token::clean($id);
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorObj = array('code' => 100, 'description' => $e->getMessage());
	}
	
	echo formResponse($data, $errorObj);
?>