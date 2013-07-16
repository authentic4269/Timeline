<?php
function formResponse ($data, $errorObj = array('code' => 0, 'description' => ''))
{
	$responseObj = array('data' => $data, 'error' => $errorObj);
	
	return json_encode($responseObj);
}
?>