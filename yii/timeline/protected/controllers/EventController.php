<?php
Yii::import('application.controllers.TimelineController');

class EventController extends TimelineController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

		);
	}
	
	public function actionTag()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('event_id') || !Yii::app()->request->getPost('tag'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Event::model()->findByPK(Yii::app()->request->getPost('event_id'));
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
				->insert('event_tags', array(
				'event_id'=>Yii::app()->request->getPost('event_id'),
				'tag_id'=>$t['id']));
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$l = Event::model()->findByPK($id);
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$l = new Event;
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$s = 'user_id';
			foreach ($_POST as $key => $value)
			{
				if ($l->hasAttribute($key))
					$l->$key = $value;
				else
					$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE'] . $key)));
			}
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if (!Yii::app()->request->getPost( 'event_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$p = Event::model()->findByPK(Yii::app()->request->getPost('event_id'));
			$o = 'user_id';
			if (empty($p)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($p->$o != Yii::app()->user->id)
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
					else if ($key != 'event_id')
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('event_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$l = Event::model()->findByPK(Yii::app()->request->getPost('event_id'));
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
				$l->delete();
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionAddResource()
	{
		if (!Yii::app()->request->getPost('event_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$l = Event::model()->findByPK(Yii::app()->request->getPost('event_id'));
			$p = Resource::model()->findByPK(Yii::app()->request->getPost('resource_id'));
			if (empty($l) || empty($p))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if (($l['user_id'] != Yii::app()->user->id) || ($p['user_id'] != Yii::app()->user->id))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$c = Yii::app()->db->createCommand()
				->insert('event_resources', array(
						'event_id'=>Yii::app()->request->getPost('event_id'),
						'resource_id'=>Yii::app()->request->getPost('resource_id')));
				$r = array('errorCode'=>0);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	/**
	 * Lists all models.
	 */
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
			->from('events')
			->where('user_id=:u_id', array(':u_id'=>Yii::app()->user->id))
			->queryAll();
			$r = array('errorCode'=>0, 'data'=>$l);
			$code = 200;
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Event('search');
		$model->unsetAttributes();  // clear any default values
		if($_GET['Event'])
			$model->attributes=$_GET['Event'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}

}
