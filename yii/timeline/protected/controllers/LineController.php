<?php
Yii::import('application.controllers.TimelineController');
class LineController extends TimelineController
{
	public function actionAddEvent()
	{
		if (!Yii::app()->request->getPost('event_id') || !Yii::app()->request->getPost('line_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$l = Line::model()->findByPK(Yii::app()->request->getPost('line_id'));
			$e = Event::model()->findByPK(Yii::app()->request->getPost('event_id'));
			if (empty($e) || empty($l)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if (($l['owner'] != Yii::app()->user->id) || ($e['user_id'] != Yii::app()->user->id)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else {
				$conn = Yii::app()->db->createCommand()
				->insert("line_events", array('line_id'=>Yii::app()->request->getPost('line_id'), 'event_id'=>Yii::app()->request->getPost('event_id')));
				$r = array('errorCode'=>0);
				$code = 200;
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
		else if (!Yii::app()->request->getPost('line_id') || !Yii::app()->request->getPost('tag'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Line::model()->findByPK(Yii::app()->request->getPost('line_id'));
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
			else if ($r['owner'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				Yii::app()->db->createCommand()
				->insert('line_tags', array(
				'line_id'=>Yii::app()->request->getPost('line_id'),
				'tag_id'=>$t['id']));
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionCreate()
	{
		$l = new Line;
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$own = 'owner';
			$auth = 'author';
			$l->$own = Yii::app()->user->id;
			$l->$auth = Yii::app()->user->id;
			if (Yii::app()->request->getPost('description'))
			{
				$desc = 'description';
				$l->$desc = Yii::app()->request->getPost('description');
			}
			if (Yii::app()->request->getPost('title'))
			{
				$desc = 'title';
				$l->$desc = Yii::app()->request->getPost('title');
			}
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

	public function actionDelete()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('line_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;			
		}
		else
		{
			$l = Line::model()->findByPK(Yii::app()->request->getPost('line_id'));
			if (empty($l)) 
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else 
			{
				$l->delete();
				$r = array('errorCode'=>0);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionDeleteEvent()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('line_id') || !Yii::app()->request->getPost('event_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;			
		}
		else
		{
			$l = Yii::app()->db->createCommand()
			->select('*')
			->from('line_events')
			->where('line_id=:l_id', array(':l_id'=>Yii::app()->request->getPost('line_id')))
			->query()->read();
			if (Yii::app()->user->id != $l['owner']) {
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				Yii::app()->db->createCommand()
				->delete('line_events')
				->where('id=:l_id', array(':l_id'=>Yii::app()->request->getPost('line_id')))
				->andWhere('event_id=:e_id', array(':e_id'=>Yii::app()->request->getPost('event_id')));
				$r = array('errorCode'=>0);
				$code = 200;
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
			->from('lines')
			->where('owner=:u_id', array(':u_id'=>Yii::app()->user->id))
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
		else if (!Yii::app()->request->getPost('line_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$l = Line::model()->findByPK(Yii::app()->request->getPost('line_id'));
			$o = 'owner';
			if (empty($l))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else
			{
				if ($l->$o != Yii::app()->user->id)
				{
					$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
					$code = 403;
				}
				else
				{
					foreach ($_POST as $key => $value)
					{
						if ($l->hasAttribute($key))
							$l->$key = $value;
						else if ($key != 'line_id')
						{
							$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorDescription'=>Yii::app()->params['ERR_PARAMS_MESSAGE'] . $key)));
							return;
						}
					}
					$r = array('errorCode'=>0);
					$code = 200;
					$u = 'owner';
					$l->$u = Yii::app()->user->id;
					$l->save();
				}
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
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
			$l = Yii::app()->db->createCommand()
			->select('*')
			->from('lines')
			->where('id=:l_id', array(':l_id'=>$id))
			->query()->read();
			if (empty($l))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($l['owner'] != Yii::app()->user->id)
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
