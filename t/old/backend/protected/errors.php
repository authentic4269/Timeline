<?php
	class Errors {
		
		private $errorDescription = array (
			'NO_ERRORS' => '',
			'INCORRECT_LOGIN_PASS' => 'Password or/and login are incorrect.<br/>Please, try again.',
			'ACCOUNT_NOT_CONFIRMED' => 'Account is not confirmed.',
			'ALREADY_REGISTERED' => 'User with specified email address already registered',
			'USERNAME_ALREADY_TAKEN' => 'Specified username is already taken',
			'PASSWORDS_NOT_MATCH' => 'Specified passwords does not match',
			'INCORRECT_CREDENTIALS' => 'Specified credentials are incorrect',
			'USER_NOT_FOUND' => 'User not found',
			'INCORRECT_EMAIL' => 'Specified email is incorrect',
			'CONFIRMATION_CODE_INVALID' => 'Confirmation code is invalid',
			'INVALID_TOKEN' => 'Token is invalid',
			'PARAMETERS_REQUIRED' => 'Parameters required',
			'PROJECT_NOT_FOUND' => 'Project with specified id not found',
			'EVENT_NOT_FOUND' => 'Event with specified id not found',
		);
		
		public function __get($name) 
		{
			$index = 0;
			foreach($this->errorDescription as $key => $desc)
			{
				if($name == $key)
					return array('code' => $index, 'description' => $desc);
				
				$index++;
			}
			
			$trace = debug_backtrace();
			trigger_error(
				'Undefined property in __get(): ' . $name .
				' in file ' . $trace[0]['file'] .
				' string number ' . $trace[0]['line'],
				E_USER_NOTICE);
			return null;
		}
	}
	
	$errors = new Errors();
?>