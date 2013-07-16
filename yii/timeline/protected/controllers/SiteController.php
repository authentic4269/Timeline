<?php
Yii::import('application.controllers.TimelineController');
class SiteController extends TimelineController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionNamecheck()
	{
		Yii::log('ghjepaulpaulpavel', 'warning', 'application.controllers.TimelineController');
		$ret = true;
		if (!Yii::app()->request->getPost('username'))
		{
			Yii::log('username='.Yii::app()->request->getPost('username'), 'warning', 'application.controllers.TimelineController');
			$ret = true;
		}
		else
		{
			Yii::log('username='.Yii::app()->request->getPost('username'), 'warning', 'application.controllers.TimelineController');
			$command = Yii::app()->db->createCommand()->select()->from('users')->where("username='" . Yii::app()->request->getPost('username') . "'");
			$result = $command->query();
			if ($result->rowCount == 0)
			{
				$ret = false;
			}
		}
		if ($ret)
			$this->sendResponse(400, 'Username taken, or bad params');
		else
			$this->sendResponse(200, 'Username is free');
		
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thsank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}


	public function actionRegister()
	{
		$model = new RegisterForm;
		if (isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']))
		{
			$m['username'] = $_POST['username'];
			$m['pass'] = $_POST['password'];
			$m['email'] = $_POST['email'];
			$m['first_name'] = $_POST['first_name'];
			$m['last_name'] = $_POST['last_name'];
			$model->attributes = $m;
			if($model->validate())
			{
				if ($model->register())
				{
					$code = 200;
					$r = array('errorCode'=>0);
				}
				else
				{
					$code = 500;
					$r = array('errorCode'=>Yii::app()->params['ERR_REGISTER_CODE'], 'errorMessage'=>Yii::app()->params['ERR_REGISTER_MESSAGE']);
				}
			}
			else
			{
				$code = 400;
				$r = array('errorCode'=>Yii::app()->params['ERR_INVALID_CODE'], 'errorMessage'=>$model->errors);
			}
			
		}
		else
		{
			$code = 400;
			$r = array('errorCode'=>Yii::app()->params['ERR_INVALID_CODE'], 'errorMessage'=>'missing params');
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		// if it is ajax validation request
		//if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		//{
		//	echo CActiveForm::validate($model);
		//	Yii::app()->end();
		//}

		// collect user input data
		if(isset($_POST['username']) && (isset($_POST['password'])))
		{
			$m['username'] = $_POST['username'];
			$m['password'] = $_POST['password'];
			$model->attributes=$m;
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				if ($model->login())
				{
					$code = 200;
					$r = array('errorCode'=>0);
				}
				else
				{
					$code = 500;
					$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
				}
			}
			else
			{
				$code = 400;
				$r = array('errorCode'=>Yii::app()->params['ERR_INVALID_CODE'], 'errorMessage'=>$model);
			}
		}
		else
		{
			$code = 403;
			$r = array('errorCode'=>Yii::app()->params['ERR_INVALID_CODE'], 'errorMessage'=>$model);
		}
		// display the login form
		$this->sendResponse($code, CJSON::encode($_POST));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->sendResponse(200, 'Logged out');
	}
	
	public function actionCheck()
	{
		if (Yii::app()->user->isGuest)
		{
			$this->sendResponse(500,"");
		}
		else
		{
			$this->sendResponse(200, "");
		}
	}
	
	public function actionConfirm($st)
	{
		$c = Yii::app()->db->createCommand()->select()->from('users')->where("confirm_string='" . $st . "'")->query();
		if ($c->rowCount == 0)
		{
			$this->redirect(Yii::app()->baseUrl);
		}
		else
		{
			Yii::app()->db->createCommand()->update('users', array('confirmed'=>1), 'confirm_string = :conf', array(':conf'=>$st));
			$this->redirect(Yii::app()->loginUrl);
		}
	}
}
