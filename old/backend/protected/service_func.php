<?php
	function requirePostFields($field_names) {
		$result = array();
		foreach ($field_names as $field) {
			if (!isset($_POST[$field])) {
				return false;
			}
			$result[$field] = $_POST[$field];
		}
		return $result;
	}
	
	function dbFieldToPost($field_name) {
		$name_blocks = explode('_', $field_name);
		
		for ($i=1; $i<count($name_blocks);$i++) {
			$name_blocks[$i] = ucfirst($name_blocks[$i]);
		}
		return   implode($name_blocks);
	}

	// function enter()
	// { 
		// global $sqlController;
		
		// $error = array();
		
		// if ($_POST['login'] != "" && $_POST['password'] != "")
		// {
			// $login = $sqlController->escapeString($_POST['login']); 
			// $password = $sqlController->escapeString($_POST['password']);

			// $row = $sqlController->query("SELECT id, password FROM user WHERE username = '$login' AND is_admin = 1");
			// if (count($row) == 1)
			// {
				// if(md5($password) == $row[0]['password'])
				// {
					// $_SESSION['uid'] = $row[0]['id'];
					// return $error;
				// }
				// else
				// {
					// $error[] = "Wrong password";
					// return $error;
				// }
			// }
			// else
			// {
				// $error[] = "User not found";
				// return $error;
			// }
		// }
		// else
		// {
			// $error[] = "Fields must be filled";
			// return $error;
		// }
	// }
	
	// function login () 
	// {
		// ini_set ("session.use_trans_sid", true); 
		// session_start();  
		
		// if (isset($_SESSION['uid']))
			// return true;
		// else
			// return false; 
	// }
	
	// function out () {
		// session_start();
		
		// unset($_SESSION['uid']);
		
		// header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
	// }
	
	// function is_admin($id) {
		// global $sqlController;
		
		// $row = $sqlController->query("SELECT is_admin FROM user WHERE id=$id AND is_admin = 1");

		// if (count($row) == 1)
			// return true;
		// else 
			// return false; 
	// }
	
	// function changePassword($old, $password, $repeat)
	// {
		// global $sqlController, $UID;
		
		// $error = array();
		
		// if(!strlen($old) || !strlen($password) || !strlen($repeat))
		// {
			// $error[] = "Fields must be filled";
			// return $error;
		// }
		
		// $ecnryptedOldPassword = md5($old);
		
		// $row = $sqlController->query("SELECT id FROM user WHERE id = $UID AND password='$ecnryptedOldPassword'");
		
		// if (count($row))
		// {
			// if(strlen($password) < 6)
			// {
				// $error[] = "Password length should not be less than 6 symbols";
				// return $error;
			// }
			
			// if(!preg_match("/^[0-9a-z]*$/i", $password))
			// {
				// $error[] = "Only latin letters and numbers are allowed";
				// return $error;
			// }
			
			// if($password != $repeat)
			// {
				// $error[] = "Passwords does not match";
				// return $error;
			// }
			
			// $ecnryptedPassword = md5($password);
			// $row = $sqlController->query("UPDATE user SET password='$ecnryptedPassword' WHERE id=$UID");
		// }
		// else
		// {
			// $error[] = "Old password is invalid";
			// return $error;
		// }
	// }
?>