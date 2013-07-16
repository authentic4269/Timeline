<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property string $link
 * @property string $short_link
 * @property integer $start_date_year
 * @property integer $start_date_month
 * @property integer $start_date_day
 * @property string $start_date_time
 * @property integer $end_date_year
 * @property integer $end_date_month
 * @property integer $end_date_day
 * @property string $end_date_time
 * @property string $description
 * @property string $language
 * @property string $created
 * @property string $last_modified
 * @property integer $category_id
 * @property string $tags
 * @property integer $age_rating_id
 * @property integer $learning_level_id
 * @property integer $views_id
 * @property integer $grade
 * @property integer $flag_id
 * @property integer $folder_id
 * @property integer $calendar_id
 *
 * The followings are the available model relations:
 * @property Comments[] $comments
 * @property ProjectCalendars[] $projectCalendars
 * @property AgeRatings $ageRating
 * @property Category $category
 * @property Flags $flag
 * @property Folders $folder
 * @property LearningLevels $learningLevel
 * @property Users $user
 * @property ProjectsEvents[] $projectsEvents
 * @property ProjectsLines[] $projectsLines
 * @property ProjectsTags[] $projectsTags
 * @property Views $views
 */
class Project extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Project the static model class
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
		return 'projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, link, category_id', 'required'),
			array('user_id, start_date_year, start_date_month, start_date_day, end_date_year, end_date_month, end_date_day, category_id, age_rating_id, learning_level_id, views_id, grade, flag_id, folder_id, calendar_id', 'numerical', 'integerOnly'=>true),
			array('title, short_link, language, tags', 'length', 'max'=>45),
			array('link', 'length', 'max'=>1024),
			array('description', 'length', 'max'=>5000),
			array('start_date_time, end_date_time, created, last_modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, user_id, link, short_link, start_date_year, start_date_month, start_date_day, start_date_time, end_date_year, end_date_month, end_date_day, end_date_time, description, language, created, last_modified, category_id, tags, age_rating_id, learning_level_id, views_id, grade, flag_id, folder_id, calendar_id', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comments', 'project_id'),
			'projectCalendars' => array(self::HAS_MANY, 'ProjectCalendars', 'project_id'),
			'ageRating' => array(self::BELONGS_TO, 'AgeRatings', 'age_rating_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'flag' => array(self::BELONGS_TO, 'Flags', 'flag_id'),
			'folder' => array(self::BELONGS_TO, 'Folders', 'folder_id'),
			'learningLevel' => array(self::BELONGS_TO, 'LearningLevels', 'learning_level_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'projectsEvents' => array(self::HAS_MANY, 'ProjectsEvents', 'project_id'),
			'projectsLines' => array(self::HAS_MANY, 'ProjectsLines', 'project_id'),
			'projectsTags' => array(self::HAS_MANY, 'ProjectsTags', 'project_id'),
			'views' => array(self::HAS_ONE, 'Views', 'project_id'),
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
			'user_id' => 'User',
			'link' => 'Link',
			'short_link' => 'Short Link',
			'start_date_year' => 'Start Date Year',
			'start_date_month' => 'Start Date Month',
			'start_date_day' => 'Start Date Day',
			'start_date_time' => 'Start Date Time',
			'end_date_year' => 'End Date Year',
			'end_date_month' => 'End Date Month',
			'end_date_day' => 'End Date Day',
			'end_date_time' => 'End Date Time',
			'description' => 'Description',
			'language' => 'Language',
			'created' => 'Created',
			'last_modified' => 'Last Modified',
			'category_id' => 'Category',
			'tags' => 'Tags',
			'age_rating_id' => 'Age Rating',
			'learning_level_id' => 'Learning Level',
			'views_id' => 'Views',
			'grade' => 'Grade',
			'flag_id' => 'Flag',
			'folder_id' => 'Folder',
			'calendar_id' => 'Calendar',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('short_link',$this->short_link,true);
		$criteria->compare('start_date_year',$this->start_date_year);
		$criteria->compare('start_date_month',$this->start_date_month);
		$criteria->compare('start_date_day',$this->start_date_day);
		$criteria->compare('start_date_time',$this->start_date_time,true);
		$criteria->compare('end_date_year',$this->end_date_year);
		$criteria->compare('end_date_month',$this->end_date_month);
		$criteria->compare('end_date_day',$this->end_date_day);
		$criteria->compare('end_date_time',$this->end_date_time,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_modified',$this->last_modified,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('age_rating_id',$this->age_rating_id);
		$criteria->compare('learning_level_id',$this->learning_level_id);
		$criteria->compare('views_id',$this->views_id);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('flag_id',$this->flag_id);
		$criteria->compare('folder_id',$this->folder_id);
		$criteria->compare('calendar_id',$this->calendar_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}