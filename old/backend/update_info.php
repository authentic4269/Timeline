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
			$result = $sqlController->query("SELECT * FROM users WHERE id=$id");
			
			$insert = array();
			foreach ($result[0] as $key => $value) {
				if(!preg_match("/^(id|username|email|password|confirmed|confirm_string|registered|updated)$/i", $key))
					$insert[$key] = (isset($_POST[dbFieldToPost($key)])) ?  $sqlController->esc($_POST[dbFieldToPost($key)]) : "'$value'";
			}
			$insert_sql = '';
			foreach ($insert as $key => $value) {
				if($value)
				{
					if(strlen($insert_sql))
						$insert_sql .= ', ';
					$insert_sql .= "$key = $value";
				}
			}
			
			// $firstName = (isset($_POST['firstName']))? $sqlController->esc($_POST['firstName']) : $result[0]['first_name'];
			// $lastName = (isset($_POST['lastName'])? $sqlController->esc($_POST['lastName']) : $result[0]['last_name'];
			// $about = (isset($_POST['about'])? $sqlController->esc($_POST['about']) : $result[0]['about'];
			// $avatar = (isset($_POST['avatar'])? $sqlController->esc($_POST['avatar']) : $result[0]['avatar'];
			// $accauntType = (isset($_POST['accauntType'])? $sqlController->esc($_POST['accauntType']) : $result[0]['accaunt_type'];
			// $birthday = (isset($_POST['birthday'])? $sqlController->esc($_POST['birthday']) : $result[0]['birthday'];
			// $jobTitle = (isset($_POST['jobTitle'])? $sqlController->esc($_POST['jobTitle']) : $result[0]['job_title'];
			// $profession = (isset($_POST['profession'])? $sqlController->esc($_POST['profession']) : $result[0]['profession'];
			// $country = (isset($_POST['country'])? $sqlController->esc($_POST['country']) : $result[0]['country'];
			// $timeOffset = (isset($_POST['timeOffset'])? $sqlController->esc($_POST['timeOffset']) : $result[0]['time_offset'];
			// $website = (isset($_POST['website'])? $sqlController->esc($_POST['website']) : $result[0]['website'];
			// $facebook = (isset($_POST['facebook'])? $sqlController->esc($_POST['facebook']) : $result[0]['facebook'];
			// $linkedin = (isset($_POST['linkedin'])? $sqlController->esc($_POST['linkedin']) : $result[0]['linkedin'];
			// $twitter = (isset($_POST['twitter'])? $sqlController->esc($_POST['twitter']) : $result[0]['twitter'];
			// $reddit = (isset($_POST['reddit'])? $sqlController->esc($_POST['reddit']) : $result[0]['reddit'];
			// $googlePlus = (isset($_POST['googlePlus'])? $sqlController->esc($_POST['googlePlus']) : $result[0]['googleplus'];
			
			$query = "UPDATE users SET $insert_sql WHERE id=$id";
			
			$result = $sqlController->query($query);
			$data = array('updated' => true);
		}
		else
		{
			Token::reset();
			$data = array('updated' => false);
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