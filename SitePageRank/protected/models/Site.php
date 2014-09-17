<?php

/**
 * This is the model class for table "site".
 *
 * The followings are the available columns in table 'site':
 * @property integer $SiteID
 * @property string $name
 * @property string $site
 * @property integer $groupid
 * @property string $type
 * @property integer $Enable
 *
 * The followings are the available model relations:
 * @property Site $site0
 * @property Site $site01
 */
class Site extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, site, groupid', 'required'),
			array('groupid, Enable', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('site', 'length', 'max'=>400),
			array('type', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('SiteID, name, site, groupid, type, Enable', 'safe', 'on'=>'search'),
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
			'site0' => array(self::BELONGS_TO, 'Site', 'SiteID'),
			'site01' => array(self::HAS_ONE, 'Site', 'SiteID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SiteID' => '編號',
			'name' => '單位名稱',
			'site' => '網址',
			'groupid' => '群組',
			'type' => '單位類型',
			'Enable' => '啟用',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('SiteID',$this->SiteID);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('groupid',$this->groupid);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('Enable',$this->Enable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Site the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
