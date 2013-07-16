<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		if($id = Token::getId())
		{
			$result = $sqlController->query("SELECT COLUMN_NAME FROM  INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='timeline' AND TABLE_NAME='calendars'");
			
			$fields = array();
			$break = false;
			$columns = '';
			$values = '';
			
			for($i = 0; $i < count($result); $i++)
			{
				$columnName = $result[$i]['COLUMN_NAME'];
					if(isset($_POST[dbFieldToPost($columnName)])) {
						$columnValue = $sqlController->esc($_POST[dbFieldToPost($columnName)]);
						
						if(strlen($values) != 0) {
							$values .= ', ';
							$columns .= ', ';
						}
						$columns .= $columnName;
						$values .= $columnValue;

					}
			}
			
			$query = "INSERT INTO calendars($columns) VALUES($values)";
			$result = $sqlController->query($query);
			$query = "SELECT MAX(id) as max FROM calendars";
			$result = $sqlController->query($query);
			$data = array('uploaded' => true, 'recordId' => $result[0]['max']);
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