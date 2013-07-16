<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $first_name;
	public $last_name;
	public $email;
	public $pass;
	public $repass;
	public $username;
	
	public function rules()
        {
                return array(
                        array('username, pass, email, last_name, first_name', 'required'),
			array('username', 'unique'),
			array('email', 'email'),
                );
        }

	public function matcher($attribute, $params)
	{
		if (!($this->pass == $this->repass))
		{
			$this->addError('repass', 'Passwords do not match');
		}
	}
	
	public function unique($attribute, $params)
	{
		$command = Yii::app()->db->createCommand()->select()->from('users')->where("username='" . $this->username . "'");
		$result = $command->query();
		if ($result->rowCount != 0)
		{
			$this->addError('username', 'That username is taken ');
		}
	}

	public function register()
	{
			$confirm = substr(md5(rand()), 0, 20);
			$command = Yii::app()->db->createCommand()->insert('users', array(
			'first_name'=>$this->first_name,
			'last_name'=>$this->last_name,
			'hash'=>hash("sha512", $this->pass),
			'username'=>$this->username,
			'email'=>$this->email,
			'confirmed'=>0,
			'confirm_string'=>$confirm,
			));
			$message = new YiiMailMessage;
			$message->addTo($this->email);
			$message->from = 'vogelmitchell22@gmail.com';
			$message->view = 'confirm';
			$message->subject = 'Timeline Registration';
			$params = array('confirm'=>$confirm, 'redirect'=>Yii::app()->baseUrl);
			$message->setBody($params, 'text/html');
			Yii::app()->mail->send($message);
			return true;
	}
}
