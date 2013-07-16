<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $confirmed
 * @property string $confirm_string
 * @property string $registered
 * @property string $updated
 * @property string $about
 * @property string $avatar
 * @property integer $account_type
 * @property string $birthday
 * @property string $job_title
 * @property string $profession
 * @property string $country
 * @property integer $time_offset
 * @property string $website
 * @property string $facebook
 * @property string $linkedin
 * @property string $twitter
 * @property string $reddit
 * @property string $googleplus
 *
 * The followings are the available model relations:
 * @property Projects[] $projects
 * @property UsersAuth[] $usersAuths
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('confirmed, account_type, time_offset', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, username, email, password, confirm_string, avatar, job_title, profession, country, website, facebook, linkedin, twitter, reddit, googleplus', 'length', 'max'=>45),
			array('about', 'length', 'max'=>1500),
			array('registered, updated, birthday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, username, email, password, confirmed, confirm_string, registered, updated, about, avatar, account_type, birthday, job_title, profession, country, time_offset, website, facebook, linkedin, twitter, reddit, googleplus', 'safe', 'on'=>'search'),
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
			'projects' => array(self::HAS_MANY, 'Projects', 'user_id'),
			'usersAuths' => array(self::HAS_MANY, 'UsersAuth', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'confirmed' => 'Confirmed',
			'confirm_string' => 'Confirm String',
			'registered' => 'Registered',
			'updated' => 'Updated',
			'about' => 'About',
			'avatar' => 'Avatar',
			'account_type' => 'Account Type',
			'birthday' => 'Birthday',
			'job_title' => 'Job Title',
			'profession' => 'Profession',
			'country' => 'Country',
			'time_offset' => 'Time Offset',
			'website' => 'Website',
			'facebook' => 'Facebook',
			'linkedin' => 'Linkedin',
			'twitter' => 'Twitter',
			'reddit' => 'Reddit',
			'googleplus' => 'Googleplus',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('confirmed',$this->confirmed);
		$criteria->compare('confirm_string',$this->confirm_string,true);
		$criteria->compare('registered',$this->registered,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('account_type',$this->account_type);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('time_offset',$this->time_offset);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('linkedin',$this->linkedin,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('reddit',$this->reddit,true);
		$criteria->compare('googleplus',$this->googleplus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
