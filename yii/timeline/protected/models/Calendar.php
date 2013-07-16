<?php

/**
 * This is the model class for table "calendars".
 *
 * The followings are the available columns in table 'calendars':
 * @property integer $id
 * @property integer $asterisk_type
 * @property integer $start_date_year
 * @property integer $start_date_month
 * @property integer $start_date_day
 * @property integer $start_date_period
 * @property string $start_date_time
 * @property integer $end_date_year
 * @property integer $end_date_month
 * @property integer $end_date_day
 * @property integer $end_date_period
 * @property string $end_date_time
 * @property string $notes
 * @property string $json_object
 *
 * The followings are the available model relations:
 * @property ProjectCalendars[] $projectCalendars
 */
class Calendar extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Calendar the static model class
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
		return 'calendars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asterisk_type, start_date_year, start_date_month, start_date_day, start_date_period, end_date_year, end_date_month, end_date_day, end_date_period', 'numerical', 'integerOnly'=>true),
			array('notes', 'length', 'max'=>200),
			array('start_date_time, end_date_time, json_object', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, asterisk_type, start_date_year, start_date_month, start_date_day, start_date_period, start_date_time, end_date_year, end_date_month, end_date_day, end_date_period, end_date_time, notes, json_object', 'safe', 'on'=>'search'),
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
			'projectCalendars' => array(self::HAS_MANY, 'ProjectCalendars', 'calendar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'asterisk_type' => 'Asterisk Type',
			'start_date_year' => 'Start Date Year',
			'start_date_month' => 'Start Date Month',
			'start_date_day' => 'Start Date Day',
			'start_date_period' => 'Start Date Period',
			'start_date_time' => 'Start Date Time',
			'end_date_year' => 'End Date Year',
			'end_date_month' => 'End Date Month',
			'end_date_day' => 'End Date Day',
			'end_date_period' => 'End Date Period',
			'end_date_time' => 'End Date Time',
			'notes' => 'Notes',
			'json_object' => 'Json Object',
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
		$criteria->compare('asterisk_type',$this->asterisk_type);
		$criteria->compare('start_date_year',$this->start_date_year);
		$criteria->compare('start_date_month',$this->start_date_month);
		$criteria->compare('start_date_day',$this->start_date_day);
		$criteria->compare('start_date_period',$this->start_date_period);
		$criteria->compare('start_date_time',$this->start_date_time,true);
		$criteria->compare('end_date_year',$this->end_date_year);
		$criteria->compare('end_date_month',$this->end_date_month);
		$criteria->compare('end_date_day',$this->end_date_day);
		$criteria->compare('end_date_period',$this->end_date_period);
		$criteria->compare('end_date_time',$this->end_date_time,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('json_object',$this->json_object,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}