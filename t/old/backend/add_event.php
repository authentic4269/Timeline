<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorCode = 0;
		$errorDescription = '';
		
		if (($id = Token::getId()) && (requirePostFields(array('title'))))
		{
			//$result = $sqlController->query("SELECT * FROM  projects WHERE id=0");
			$result = $sqlController->query("SELECT COLUMN_NAME FROM  INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='timeline' AND TABLE_NAME='events'");
			
			$fields = array();
			$break = false;
			$columns = '';
			$values = '';
			
			for($i = 0; $i < count($result); $i++)
			{
				$columnName = $result[$i]['COLUMN_NAME'];
				$field = dbFieldToPost($columnName);
				if(isset($field)) {
					$columnValue = $sqlController->esc($_POST[$field]);
					
					if(strlen($values) != 0)
						$values .= ', ';
			
					$values .= $columnValue;
				}
				else
					break;
				if(strlen($columns) != 0)
					$columns .= ', ';
			
				$columns .= $columnName;			
			}	
			$query = "INSERT INTO events($columns) VALUES($values)";
			var_export($query);
			$result = $sqlController->query($query);
			$id_query = "SELECT MAX(id) FROM events";
			$id_result = $sqlController->query($id_query);
			$data = array('uploaded' => true, 'recordId' => $id_result['id']);
		}
		else
		{
			setcookie('token', '');
			$data = array('uploaded' => false);
			$errorCode = 10;
			$errorDescription = 'Token is invalid';
		}
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorCode = 100;
		$errorDescription = $e->getMessage();
	}
	
	echo formResponse($data, $errorCode, $errorDescription);
?>