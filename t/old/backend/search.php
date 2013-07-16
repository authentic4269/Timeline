<?php
	require_once('protected/config.php');
	require_once('protected/response.php');
	
	try
	{
		$data = NULL;
		$errorObj = array('code' => 0, 'description' => '');
		
		// if($id = Token::getId())
		// {
			//$result = $sqlController->query("SELECT * FROM  projects WHERE id=0");
			
			if(isset($_POST['keyword'])){
				$keyword = $sqlController->esc($_POST['keyword']);
				
				$data = array('found' => false);
				$results = array();
				
				$result = $sqlController->query("SELECT p.id, p.title, p.link, u.first_name, u.last_name FROM  projects p INNER JOIN users u on u.id=p.user_id WHERE title like '%$keyword%'");
				
				if(count($result) != 0)
				{
					$results['projects'] = $result;
					$data = array('found' => true);
				}
				
				$result = $sqlController->query("SELECT e.id, e.title, p.link, u.first_name, u.last_name FROM events e INNER JOIN projects_events pe ON pe.event_id = e.id INNER JOIN projects p ON p.id = pe.project_id INNER JOIN users u ON u.id=p.user_id WHERE e.title like '%$keyword%'");
				
				if(count($result) != 0)
				{
					$results['events'] = $result;
					$data = array('found' => true);
				}
				
				$result = $sqlController->query("SELECT l.id, l.title, p.link, u.first_name, u.last_name FROM lines l INNER JOIN projects_lines pl ON pl.line_id = l.id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN users u ON u.id=p.user_id WHERE l.title like '%$keyword%'");
				
				if(count($result) != 0)
				{
					$results['lines'] = $result;
					$data = array('found' => true);
				}
			}
			else
			{
				$data = array('found' => false);
				$errorObj = $errors->PARAMETERS_REQUIRED;
			}
			
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
		// }
		// else
		// {
			// Token::reset();
			// $data = array('uploaded' => false);
			// $errorObj = $errors->INVALID_TOKEN;
		// }
	}
	catch(Exception $e)
	{
		header("HTTP/1.0 404 Not Found");
		$data = NULL;
		$errorObj = array('code' => 100, 'description' => $e->getMessage());
	}
	
	echo formResponse($data, $errorObj);
?>