<?php

/**
 * This is the model class for table "data".
 *
 * The followings are the available columns in table 'data':
 * @property string $DataID
 * @property integer $SiteID
 * @property string $filetime
 * @property integer $robot
 * @property integer $sitemap
 * @property string $GoogleData
 * @property integer $google_page_rank
 * @property string $google_backlink
 * @property string $alexa_rank
 * @property string $alexa_rank_tw
 * @property string $alexa_link
 * @property string $GooglePlusShares
 * @property string $TwitterShares
 * @property string $Facebook
 * @property string $FB_share_count
 * @property string $FB_like_count
 * @property string $FB_comment_count
 * @property string $FB_commentsbox_count
 * @property string $FB_click_count
 * @property string $LinkedInShares
 * @property string $pdf
 * @property string $doc
 * @property string $docx
 * @property string $ppt
 * @property string $pptx
 * @property string $ps
 * @property string $eps
 * @property string $Time
 * @property integer $YY
 * @property integer $MM
 * @property integer $DD
 * @property string $TaskID
 *
 * The followings are the available model relations:
 * @property SiteUrl $site
 */
class Data extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SiteID, YY, MM, DD', 'required'),
			array('SiteID, robot, sitemap, google_page_rank, YY, MM, DD', 'numerical', 'integerOnly'=>true),
			array('GoogleData, google_backlink, alexa_rank, alexa_rank_tw, GooglePlusShares, TwitterShares, Facebook, FB_share_count, FB_like_count, FB_comment_count, FB_commentsbox_count, FB_click_count, LinkedInShares, pdf, doc, docx, ppt, pptx, ps, eps, TaskID', 'length', 'max'=>20),
			array('alexa_link', 'length', 'max'=>11),
			array('filetime, Time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('DataID, SiteID, filetime, robot, sitemap, GoogleData, google_page_rank, google_backlink, alexa_rank, alexa_rank_tw, alexa_link, GooglePlusShares, TwitterShares, Facebook, FB_share_count, FB_like_count, FB_comment_count, FB_commentsbox_count, FB_click_count, LinkedInShares, pdf, doc, docx, ppt, pptx, ps, eps, Time, YY, MM, DD, TaskID', 'safe', 'on'=>'search'),
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
			'site' => array(self::BELONGS_TO, 'SiteUrl', 'SiteID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'DataID' => '資料ID',
			'SiteID' => 'Site',
			'filetime' => 'Filetime',
			'robot' => 'Robot',
			'sitemap' => 'Sitemap',
			'GoogleData' => '取得資料',
			'google_page_rank' => 'Google Page Rank',
			'google_backlink' => 'Google Backlink',
			'alexa_rank' => 'Alexa Rank',
			'alexa_rank_tw' => 'Alexa Rank Tw',
			'alexa_link' => 'Alexa Link',
			'GooglePlusShares' => 'Google Plus Shares',
			'TwitterShares' => 'Twitter Shares',
			'Facebook' => 'Facebook',
			'FB_share_count' => 'Fb Share Count',
			'FB_like_count' => 'Fb Like Count',
			'FB_comment_count' => 'Fb Comment Count',
			'FB_commentsbox_count' => 'Fb Commentsbox Count',
			'FB_click_count' => 'Fb Click Count',
			'LinkedInShares' => 'Linked In Shares',
			'pdf' => 'Pdf',
			'doc' => 'Doc',
			'docx' => 'Docx',
			'ppt' => 'Ppt',
			'pptx' => 'Pptx',
			'ps' => 'Ps',
			'eps' => 'Eps',
			'Time' => '記錄時間',
			'YY' => '年',
			'MM' => '月',
			'DD' => '日',
			'TaskID' => 'Task',
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

		$criteria->compare('DataID',$this->DataID,true);
		$criteria->compare('SiteID',$this->SiteID);
		$criteria->compare('filetime',$this->filetime,true);
		$criteria->compare('robot',$this->robot);
		$criteria->compare('sitemap',$this->sitemap);
		$criteria->compare('GoogleData',$this->GoogleData,true);
		$criteria->compare('google_page_rank',$this->google_page_rank);
		$criteria->compare('google_backlink',$this->google_backlink,true);
		$criteria->compare('alexa_rank',$this->alexa_rank,true);
		$criteria->compare('alexa_rank_tw',$this->alexa_rank_tw,true);
		$criteria->compare('alexa_link',$this->alexa_link,true);
		$criteria->compare('GooglePlusShares',$this->GooglePlusShares,true);
		$criteria->compare('TwitterShares',$this->TwitterShares,true);
		$criteria->compare('Facebook',$this->Facebook,true);
		$criteria->compare('FB_share_count',$this->FB_share_count,true);
		$criteria->compare('FB_like_count',$this->FB_like_count,true);
		$criteria->compare('FB_comment_count',$this->FB_comment_count,true);
		$criteria->compare('FB_commentsbox_count',$this->FB_commentsbox_count,true);
		$criteria->compare('FB_click_count',$this->FB_click_count,true);
		$criteria->compare('LinkedInShares',$this->LinkedInShares,true);
		$criteria->compare('pdf',$this->pdf,true);
		$criteria->compare('doc',$this->doc,true);
		$criteria->compare('docx',$this->docx,true);
		$criteria->compare('ppt',$this->ppt,true);
		$criteria->compare('pptx',$this->pptx,true);
		$criteria->compare('ps',$this->ps,true);
		$criteria->compare('eps',$this->eps,true);
		$criteria->compare('Time',$this->Time,true);
		$criteria->compare('YY',$this->YY);
		$criteria->compare('MM',$this->MM);
		$criteria->compare('DD',$this->DD);
		$criteria->compare('TaskID',$this->TaskID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Data the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
