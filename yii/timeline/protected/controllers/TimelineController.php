<?php

class TimelineController extends Controller
{
	public function hasProjectPermission($p) {
		$uid = 'user_id';
		$pub = 'public';
		if ($p->$uid == Yii::app()->user->id)
			return Yii::app()->params['OWNER'];
		if ($p->$pub)
			return Yii::app()->params['VIEWER'];
		$perm = Yii::app()->db->createCommand()
		->select('*')
		->from('project_users')
		->where('project_id=:p_id', array(':p_id'=>$p['id']))
		->andWhere('user=:u_id', array(':u_id'=>Yii::app()->user->id))->queryRow();
		if (empty($perm))
		{
			return Yii::app()->params['NO_ACCESS'];
		}
		return Yii::app()->params['VIEWER'];
	}

	public function inProject($p, $l) {
		$proj = Project::model().find(array(
				'params'=>array(':id'=>$p->attributes['id'])));
		if (empty($proj))
			return false;
		if ($l->attributes['_id'])
			return true;
	}

	public function sendResponse($status = 200, $body = '', $message = 'Server Error')
	{
		// set the status
		$status_header = 'HTTP/1.1 ' . $status;
		header($status_header);
		// and the content type
		header('Content-type: application/json');

		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
		}
		// we need to create the body if none is passed
		else
		{
			echo 'The server encountered an error processing your request';
		}
	}
	
	/**
	 * Makes a copy of a project. The copy is owned by the current user.
	 * All lines, events, and resources associated with the project are saved into
	 * the current users workspace.
	 * Requires: Current user has view permissions for project to be cloned
	 * @param $project_id the project id to be cloned
	 * @return the id of the cloned copy
	 */
	public function cloneProject($project)
	{
		$project = Project::model()->findByPk($project['id']);
		$clone = clone $project;
		$uid = 'user_id';
		$i = 'id';
		$clone->$uid = Yii::app()->user->id;
		unset($clone->$i);
		$clone->setIsNewRecord(true);
		$clone->insert();
		$id = $clone->$i;
		$l = Yii::app()->db->createCommand()
		->select('*')
		->from('projects_lines')
		->where('project_id=:p_id', array(':p_id'=>$project['id']))->query();
		foreach($l as $line)
		{
			$new_line = $this->cloneLine($line['line_id']);
			$c = Yii::app()->db->createCommand()
			->insert('projects_lines', array(
					'project_id'=>$id,
					'line_id'=>$new_line));
			$lineindex[$line['line_id']] = $new_line;
		}
		$e = Yii::app()->db->createCommand()
		->select('*')
		->from('project_events')
		->where('project_id=:p_id', array(':p_id'=>$id))->query();
		foreach($e as $event)
		{
			$new_event = $this->cloneEvent($event['event_id']);
			$c = Yii::app()->db->createCommand()
			->insert('project_events', array(
					'project_id'=>$id,
					'event_id'=>$new_event));
		}
		return $id;
	}
	
	/* We have created cloned lines already, now for each cloned event
	 * we must add in relations which mirror the relationships of the originals.
	 * lineindex tells us what old line id corresponds to what cloned line id, oldid tells us
	 * the id of the old event, and newid tells us the id of the cloned event.
	 * */
	private function makeCloneRelationships($lineindex, $oldid, $newid)
	{
		$e = Yii::app()->db->createCommand()
		->select('*')
		->from('line_events')
		->where('event_id=:e_id', array(':e_id'=>$oldid))->query();
		foreach($e as $event)
		{
			$clone = $lineindex[$e['line_id']];
			$c = Yii::app()->db->createCommand()
			->insert('line_events', array(
					'event_id'=>$newid,
					'line_id'=>$clone));
		}
	}
	
	private function copyAttrs($original, $clone)
	{
		foreach ($original->attributeNames() as $name)
		{
			$clone->$name = $original->getAttribute($name);
		}
		$i = 'id';
		unset($clone->$i);
		return $clone;
	}
	
	/**
	 * Makes a copy of a line. The copy is owned by the current user.
	 * All events, and resources associated with the line are saved into
	 * the current users workspace.
	 * Requires: Current user has view permissions for project to be cloned
	 * @param $line_id the id of the line to be cloned
	 * @return the id of the cloned copy
	 */
	public function cloneLine($line_id)
	{
		$line = Line::model()->findByPk($line_id);
		$clone = clone $line;
		$uid = 'owner';
		$i = 'id';
		unset($clone->$i);
		$clone->$uid = Yii::app()->user->id;
		$clone->setIsNewRecord(true);
		$clone->insert();
		$id = $clone->$i;
		return $id;
	}
	
	public function cloneEvent($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$clone = clone $event;
		$uid = 'user_id';
		$i = 'id';
		unset($clone->$i);
		$clone->$uid = Yii::app()->user->id;
		$clone->setIsNewRecord(true);
		$clone->insert();
		$id = $clone->$i;
		$r = Yii::app()->db->createCommand()
		->select('*')
		->from('event_resources')
		->where('event_id=:e_id', array(':e_id'=>$event_id))->query();
		foreach($r as $resource)
		{
			$new_id = $this->cloneResource($resource['resource_id']);
			$c = Yii::app()->db->createCommand()
			->insert('event_resources', array(
					'event_id'=>$id,
					'resource_id'=>$new_id));
		}
		return $id;
	}
	
	public function cloneResource($resource_id)
	{
		$resource = Resource::model()->findByPk($resource_id);
		$clone = clone $resource;
		$uid = 'user_id';
		$i = 'id';
		$clone->$uid = Yii::app()->user->id;
		$title = 'title';
		unset($clone->$i);
		$clone->setIsNewRecord(true);
		$clone->insert();
		$location = Yii::app()->params['RESOURCE_DIR'];
		copy($location . $resource_id, $location . $id);
		return $clone->$i;
	}
	
}
