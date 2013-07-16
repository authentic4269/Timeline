<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		if($id = Token::getId())
		{
			$result = $sqlController->query("SELECT COLUMN_NAME FROM  INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='timeline' AND TABLE_NAME='projects'");
			
			$fields = array();
			$break = false;
			$columns = '';
			$values = '';
			
			for($i = 0; $i < count($result); $i++)
			{
				$columnName = $result[$i]['COLUMN_NAME'];
				if(!preg_match("/^(id|created|last_modified)$/i", $columnName))
				{
					if(isset($_POST[dbFieldToPost($columnName)])) {
						$columnValue = $sqlController->esc($_POST[dbFieldToPost($columnName)]);
						
						if(strlen($values) != 0)
							$values .= ', ';
				
						$values .= $columnValue;
					}
					else if(strcmp($columnName, 'user_id') == 0)
					{
						if(strlen($values) != 0)
							$values .= ', ';
				
						$values .= $id;
					}
					else
					{
						$break = true;
						break;
					}
					
					if(strlen($columns) != 0)
						$columns .= ', ';
				
					$columns .= $columnName;
				}
			}
			
			$query = "INSERT INTO projects($columns) VALUES($values)";
			var_export($query);
			die();
			// if(){
			// }
			// else
			// {
				// $data = array('uploaded' => false);
				// $errorObj = $errors->PARAMETERS_REQUIRED;
			// }
			$data = array('uploaded' => true, 'recordId' => $recordId);
		}
		else
		{
			Token::reset();
			$data = array('uploaded' => false);
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