<?php
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
			if(isset($_POST['projectId']))
			{
				$projectId = $sqlController->esc($_POST['projectId']);
				
				$result = $sqlController->query("SELECT e.id, e.title, e.text,
														e.description, e.start_date_month, 
														e.end_date_time, e.end_date_period, 
														e.end_date_day, e.end_date_month, 
														e.end_date_year, e.start_date_time, 
														e.start_date_period, e.start_date_day, 
														e.start_date_year 
												FROM events e 
												INNER JOIN projects_events pe ON pe.event_id=e.id 
												INNER JOIN projects p ON pe.project_id=p.id 
												WHERE p.id=$projectId");
				
				if(count($result) == 1)
					$data = array('fetched' => true, 'eventInfo' => $result[0]);
				else
				{
					$data = array('fetched' => false);
					$errorObj = $errors->EVENT_NOT_FOUND;
				}
			}
			else
			{
				$data = array('fetched' => false);
				$errorObj = $errors->PARAMETERS_REQUIRED;
			}
		}
		else
		{
			Token::reset();
			$data = array('fetched' => false);
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
?>