<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $description
 * @property integer $start_date_month
 * @property string $end_date_time
 * @property integer $end_date_day
 * @property integer $end_date_month
 * @property integer $end_date_year
 * @property string $start_date_time
 * @property integer $start_date_day
 * @property integer $start_date_year
 *
 * The followings are the available model relations:
 * @property EventRelationships[] $eventRelationships
 * @property EventRelationships[] $eventRelationships1
 * @property ProjectsEvents[] $projectsEvents
 */
class Event extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date_month, end_date_day, end_date_month, end_date_year, start_date_day, start_date_year', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('text', 'length', 'max'=>5000),
			array('description', 'length', 'max'=>500),
			array('end_date_time, start_date_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, text, description, start_date_month, end_date_time, end_date_day, end_date_month, end_date_year, start_date_time, start_date_day, start_date_year', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'eventRelationships' => array(self::HAS_ONE, 'EventRelationships', 'parent_id'),
			'eventRelationships1' => array(self::HAS_MANY, 'EventRelationships', 'child_id'),
			'projectsEvents' => array(self::HAS_MANY, 'ProjectsEvents', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'text' => 'Text',
			'description' => 'Description',
			'start_date_month' => 'Start Date Month',
			'end_date_time' => 'End Date Time',
			'end_date_day' => 'End Date Day',
			'end_date_month' => 'End Date Month',
			'end_date_year' => 'End Date Year',
			'start_date_time' => 'Start Date Time',
			'start_date_day' => 'Start Date Day',
			'start_date_year' => 'Start Date Year',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date_month',$this->start_date_month);
		$criteria->compare('end_date_time',$this->end_date_time,true);
		$criteria->compare('end_date_day',$this->end_date_day);
		$criteria->compare('end_date_month',$this->end_date_month);
		$criteria->compare('end_date_year',$this->end_date_year);
		$criteria->compare('start_date_time',$this->start_date_time,true);
		$criteria->compare('start_date_day',$this->start_date_day);
		$criteria->compare('start_date_year',$this->start_date_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
