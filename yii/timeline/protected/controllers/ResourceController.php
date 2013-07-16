<?php
Yii::import('application.controllers.TimelineController');
Yii::import('ext.google-api-php-client.src.Google_Client.php');
class ResourceController extends TimelineController
{
	public function actionCreate()
	{
		$l = new Resource;
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			foreach ($_POST as $key => $value)
			{
				if ($l->hasAttribute($key))
					$l->$key = $value;
				else
					$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE'] . $key)));
			}
			$s = 'user_id';
			$l->$s = Yii::app()->user->id;
			if ($l->save())
			{
				$code = 200;
				$r = array('errorCode'=>0, 'data'=>$l);
			}
			else
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_SAVE_CODE'], 'errorMessage'=>(Yii::app()->params['ERR_SAVE_MESSAGE'] . $l->errors));
				$code = 500;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));	
	}
	
	public function actionTag()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('resource_id') || !Yii::app()->request->getPost('tag'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Resource::model()->findByPK(Yii::app()->request->getPost('resource_id'));
			$t = Yii::app()->db->createCommand()
			->select('*')
			->from('tags')
			->where('name=:n', array(':n'=>Yii::app()->request->getPost('tag')))
			->query()->read();
			if (!$t['id'])
			{
				$new_tag = Yii::app()->db->createCommand()
				->insert('tags', array(
						"name"=>Yii::app()->request->getPost('tag')
				));
				$t = Yii::app()->db->createCommand()
			->select('*')
			->from('tags')
			->where('name=:n', array(':n'=>Yii::app()->request->getPost('tag')))
			->query()->read();
			}
			if (empty($r))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($r['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				Yii::app()->db->createCommand()
				->insert('resource_tags', array(
				'resource_id'=>Yii::app()->request->getPost('resource_id'),
				'tag_id'=>$t['id']));
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionSave()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('resource_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			cloneResource(Yii::app()->request->getPost('resource_id'));
			$r = array('errorCode'=>0);
			$code = 200;
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionDelete()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('resource_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$l = Resource::model()->findByPK(Yii::app()->request->getPost('resource_id'));
			if (empty($l))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else
			{
				$l->delete();
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionList()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$l = Yii::app()->db->createCommand()
			->select('*')
			->from('resources')
			->where('user_id=:u_id', array(':u_id'=>Yii::app()->user->id))
			->queryAll();
			$r = array('errorCode'=>0, 'data'=>$l);
			$code = 200;
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionUpdate()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (Yii::app()->request->getPost('resource_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$p = Resource::model()->findByPK(Yii::app()->request->getPost('resource_id'));
			if (empty($p)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($p['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				foreach ($_POST as $key => $value)
				{
					if ($p->hasAttribute($key))
						$p->$key = $value;
					else  if ($key != 'resource_id')
					{
						$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE'] . $key)));
						return;
					}
				}
				$s = 'user_id';
				$p->$s = Yii::app()->user->id;
				if ($p->save())
				{
					$code = 200;
					$r = array('errorCode'=>0);
				}
				else
				{
					$r = array('errorCode'=>Yii::app()->params['ERR_SAVE_CODE'], 'errorMessage'=>(Yii::app()->params['ERR_SAVE_MESSAGE'] . $l->errors));
					$code = 500;
				}
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	private function getResourceFromCloud($id)
	{
		$client = new Google_Client();
		$client->setApplicationName("Timeline");
		$key = file_get_contents("../config/889f01b9d6fce162dc713702110ff9570cc72349-privatekey.p12");
		$client->setAssertionCredentials(new Google_AssertionCredentials(
			'198743631649-7no8796ilrj3jvo7r2lmbi8fukp7v14a',
			array('https://www.googleapis.com/auth/devstorage.read_write'),
			$key)
		);
		$client->setClientId('198743631649-7no8796ilrj3jvo7r2lmbi8fukp7v14a');
		die(var_dump($client->getAccessToken()));
	}
	
	public function actionTest()
	{
		$this->sendResponse(200, CJSON::encode($this->getResourceFromCloud(1)));
	}
	
	public function actionView($id)
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$l = Resource::model()->findByPK($id);
			if (empty($l))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($l['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$r = array('errorCode'=>0, 'data'=>$l);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
}