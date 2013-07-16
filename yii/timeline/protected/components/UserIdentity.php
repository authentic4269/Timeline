<?php

class UserIdentity extends CUserIdentity {
	
	public $username = '';
	public $password = '';
	public $_id;
	public $errorMessage = ' ';

	public function authenticate() {
		$this->errorCode = 0;
		$c = Yii::app()->db->createCommand()->select()->from('users')->where("username='" . $this->username . "'")->query();
		$result = $c->read();
		if($c===null)
		{
			$this->errorMessage = "no record found";
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else if($result['hash'] != hash("sha512", $this->password))
		{
			$this->errorMessage = $result['hash'] . ",  " . hash("sha512", $this->password) . ", " . $this->username;
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		/*else if ($result['confirmed'] == 0)
		{
			$this->errorMessage = "This account has not been confirmed";
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}*/
		else
		{
			$this->_id = $result['id'];
			$this->errorCode=self::ERROR_NONE;
			return true;
		}
		return false;
	}

	public function getId()
	{
		return $this->_id;
	}	
	
	public function UserIdentity($un, $pass) {
		$this->username = $un;
		$this->password = $pass;
	}
}