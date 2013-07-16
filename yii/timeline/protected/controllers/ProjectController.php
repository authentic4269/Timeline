<?php
Yii::import('application.controllers.TimelineController');
class ProjectController extends TimelineController
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
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array();
	}
	
	public function actionLines() 
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}			
		else
		{
			$id = Yii::app()->request->getPost('project_id');
			$project = Project::model()->findByPK($id);
			if (empty($project))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($project['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$res = Yii::app()->db->createCommand("SELECT * FROM (SELECT * FROM `projects_lines` WHERE project_id=" . $id . ") AS x JOIN `lines` ON x.line_id=lines.id")->queryAll();
				$r = array('errorCode'=>0, 'data'=>$res);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionFlag()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('project_id') || !Yii::app()->request->getPost('flag') || !Yii::app()->request->getPost('reason'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else 
		{
			$id = Yii::app()->request->getPost('project_id');
			$project = Project::model()->findByPK($id);
			if (empty($project))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($project['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$res = Yii::app()->db->createCommand("SELECT * FROM (SELECT * FROM `projects_events` WHERE project_id=" . $id . ") AS x JOIN `events` ON x.event_id=events.id")->queryAll();
				$r = array('errorCode'=>0, 'data'=>$res);
				$code = 200;
			}
		}
	}
	
	public function actionEvents()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$id = Yii::app()->request->getPost('project_id');
			$project = Project::model()->findByPK($id);
			if (empty($project))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($project['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$res = Yii::app()->db->createCommand("SELECT * FROM (SELECT * FROM `projects_events` WHERE project_id=" . $id . ") AS x JOIN `events` ON x.event_id=events.id")->queryAll();
				$r = array('errorCode'=>0, 'data'=>$res);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionGettags()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
			if ($r['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else 
			{
				$res = Yii::app()->createCommand("SELECT name
				FROM tags AS T
				WHERE T.id
				IN (
					SELECT tag_id
					FROM  `projects_tags` 
					WHERE project_id =" . Yii::app()->request->getPost('project_id') . "
				)")->queryAll();
				$r = array('errorCode'=>0, 'data'=>$res);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	
	public function actionDeletetag()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('project_id') || !Yii::app()->request->getPost('tag'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
			$tag = Yii::app()->db->createCommand()
			->select('id')
			->from('tags')
			->where('name=:n', array(':n'=>Yii::app()->request->getPost('tag')))->query()->read();
			if (!isset($tag['id']))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$this->sendResponse(404, CJSON::encode($r));
				return;
			}
			if (empty($r))
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			if ($r['user_id'] != Yii::app()->user->id)
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else
			{
				$t = Yii::app()->db->createCommand("DELETE FROM projects_tags WHERE project_id=" . Yii::app()->request->getPost('project_id') . 
						" AND tag_id=" . $tag['id']);
				$code = 200;
				$r = array('errorCode'=>0, 'errorMessage'=>"DELETE FROM projects_tags WHERE project_id=" . Yii::app()->request->getPost('project_id') . 
						" AND tag_id=" . $tag['id']);
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
		else if (!Yii::app()->request->getPost('project_id') || !Yii::app()->request->getPost('tag'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$r = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
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
				->insert('projects_tags', array(
				'project_id'=>Yii::app()->request->getPost('project_id'),
				'tag_id'=>$t['id']));
				$code = 200;
				$r = array('errorCode'=>0);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionDeleteLine()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('line_id') || !Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$p = Project::model().find(array(
				'params'=>array(':id'=>Yii::app()->request->getPost('project_id'))));
			$l = Line::model().find(array(
				'params'=>array(':id'=>Yii::app()->request->getPost('line_id'))));
			$conn = Yii::app()->db->createCommand()
				->select('*')
				->from('project_lines')
				->where('project_id=:p_id', array(':p_id'=>Yii::app()->request->getPost('project_id')))
				->andWhere('line_id=:l_id', array(':l_id'=>Yii::app()->request->getPost('line_id')));
			if (empty($p) || empty($l) || empty($conn)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
                	        $code = 404;
			}
			else if (hasProjectPermission($p) != Yii::app()->params['OWNER']) {
				$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
				$code = 403;
			}
			else {
				$r = array('errorCode'=>0);
				$conn = Yii::app()->db->createCommand()
				->delete('project_lines', array('project_id=:p_id', 'line_id=:l_id'), 
						array(':p_id'=>Yii::app()->request->getPost('project_id'),
							':l_id'=>Yii::app()->request->getPost('line_id')));
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
		
	}

	public function actionAddLine()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else if (!Yii::app()->request->getPost('line_id') || !Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{
			$p = Project::model().find(array(
					'params'=>array(':id'=>Yii::app()->request->getPost('project_id'))));
			$l = Line::model().find(array(
					'params'=>array(':id'=>Yii::app()->request->getPost('line_id'))));

			if (empty($p) || empty($l)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else {
				$conn = Yii::app()->db->createCommand()
				->insert("project_lines", array('line_id'=>Yii::app()->request->getPost('line_id'), 'project_id'=>Yii::app()->request->getPost('project_id')));
				$r = array('errorCode'=>0);
				$code = 200;
			}
			switch (hasProjectPermission($p)) {
				case Yii::app()->params['NO_ACCESS']:
				case Yii::app()->params['VIEWER']:
					$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
					$code = 403;
				case OWNER: break;
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
		else if (!Yii::app()->request->getPost('project_id'))
		{				
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;
		}
		else
		{				
			$p = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
			if (empty($p)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}				
			switch ($this->hasProjectPermission($p)) {
				case Yii::app()->params['VIEWER']:
					$new_project_id = $this->cloneProject($p);
					$code = 200;
					$r = array('errorCode'=>0, 'data'=>$new_project_id);
					break;
				case Yii::app()->params['NO_ACCESS']:
					$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
					$code = 403;
					break;
				case Yii::app()->params['OWNER']:
					$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
					$code = 400;
					break;
				default:
					$r = array('errorCode'=>Yii::app()->params['ERR_SAVE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_SAVE_MESSAGE']);
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
		$code = 500;
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$p = Yii::app()->db->createCommand()
			->select()
			->from('projects')
			->where('id=' . $id)->query()->read();
			if (empty($p)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else if ($this->hasProjectPermission($p) != Yii::app()->params['OWNER'])
			{
					$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
					$code = 403;
			}
			else
			{
				$r = array('errorCode'=>0, 'data'=>$p);
				$code = 200;
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionListMine() 
	{
		$code = 500;
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		$p = Yii::app()->db->createCommand()
			->select('*')	
			->from('projects')
			->where('user_id=:u_id', array(':u_id'=>Yii::app()->user->id))->query();
		$this->sendResponse(200, CJSON::encode($p->readAll()));
	}

	public function actionCreate()
	{
		if (Yii::app()->user->isGuest)
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_LOGIN_CODE'], 'errorMessage'=>Yii::app()->params['ERR_LOGIN_MESSAGE']);
			$code = 401;
		}
		else
		{
			$p = new Project;
			foreach ($_POST as $key => $value)
			{
				if ($p->hasAttribute($key))
					$p->$key = $value;
				else
					$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE'] . $key)));
			}
			if (!$p->hasAttribute('calendar_id'))
			{
				$cal = 'calendar_id';
				$p->$cal = 0;
			}
			$s = 'user_id';
			$p->$s = Yii::app()->user->id;
			if ($p->save())
			{
				$code = 200;
				$r = array('errorCode'=>0, 'data'=>$p);
			}
			else
			{
				$r = array('errorCode'=>Yii::app()->params['ERR_SAVE_CODE'], 'errorMessage'=>(Yii::app()->params['ERR_SAVE_MESSAGE'] . $p->errors));
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
		else if (!Yii::app()->request->getPost('project_id'))
		{
			$r = array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorMessage'=>Yii::app()->params['ERR_PARAMS_MESSAGE']);
			$code = 400;	
		}
		else
		{
			$p = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
			if (empty($p)) {
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorMessage'=>Yii::app()->params['ERR_DNE_MESSAGE']);
				$code = 404;
			}
			else
			{
				if ($p['user_id'] != Yii::app()->user->id)
				{
					$r = array('errorCode'=>Yii::app()->params['ERR_AUTH_CODE'], 'errorMessage'=>Yii::app()->params['ERR_AUTH_MESSAGE']);
					$code = 403;
				}
				else
				{
					if ($p->delete())
					{
						$r = array('errorCode'=>0);
						$code = 200;
					}
					else
					{
						$r = array('errorCode'=>Yii::app()->params['ERR_DB_CODE'], 'errorMessage'=>(Yii::app()->params['ERR_DB_MESSAGE'] . $p->errors));
						$code = 400;
					}
				}
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}

	public function actionUpdate()
	{
		if (!Yii::app()->request->getPost('project_id'))
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
			$p = Project::model()->findByPK(Yii::app()->request->getPost('project_id'));
			$u = 'user_id';
			if (empty($p))
			{
				$code = 404;
				$r = array('errorCode'=>Yii::app()->params['ERR_DNE_CODE'], 'errorDescription'=>Yii::app()->params['ERR_DNE_MESSAGE']);
			}
			else if ($p->$u != Yii::app()->user->id)
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
					else if ($key != 'project_id')
					{
						$this->sendResponse(400, CJSON::encode(array('errorCode'=>Yii::app()->params['ERR_PARAMS_CODE'], 'errorDescription'=>Yii::app()->params['ERR_PARAMS_MESSAGE'])));
						return;
					}
				}
				$p->$u = Yii::app()->user->id;
				$p->save();
				$code = 403;
				$r = array('errorCode'=>0, 'data'=>$p);
			}
		}
		$this->sendResponse($code, CJSON::encode($r));
	}
	 
	/*
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
}
