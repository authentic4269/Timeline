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
				
				$result = $sqlController->query("SELECT p.title, u.first_name, c.id as calendar_id,
													u.last_name, p.link, p.short_link, 
													p.start_date_year, p.start_date_month,
													p.start_date_day, p.start_date_period,
													p.start_date_time, p.end_date_year,
													p.end_date_month, p.end_date_day,
													p.end_date_period, p.end_date_time,
													p.description, p.language, p.created,
													p.last_modified, cat.name as category_name, `tags`, 
													ml.name as mix_licence_name, ml.description as mix_licence_desc, 
													ar.name as age_rating_name, ar.description as age_rating_desc,
													ll.name as learning_level_name, ll.description as learning_level_desc,
													v.views, p.grade, flags.name as flag, p.folder_id
												FROM projects p 
												INNER JOIN users u ON u.id=p.user_id 
												INNER JOIN categories cat ON cat.id=p.category_id 
												INNER JOIN mix_licences ml ON ml.id=p.mix_licence_id 
												INNER JOIN age_ratings ar ON ar.id=p.age_rating_id 
												INNER JOIN learning_levels ll ON ll.id=p.learning_level_id
												INNER JOIN views v ON v.project_id=p.id 
												INNER JOIN flags ON f.id=p.flag_id
												INNER JOIN folders ON f.id=p.folder_id 
												INNER JOIN calendars c ON c.id=p.calendar_id 
												WHERE p.id=$projectId");
				
				if(count($result) == 1)
					$data = array('fetched' => true, 'projectInfo' => $result[0]);
				else
				{
					$data = array('fetched' => false);
					$errorObj = $errors->PROJECT_NOT_FOUND;
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