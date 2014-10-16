<?php

class DataController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','GetJson','GetOfficeJson','GetTeachJson','GetJsonByID','GetOfficeJsonByID','GetTeachJsonByID','GetJsonDetailByID','Rank','RankOffice','RankTeach','Detail','GetJsonHistory'),
				'users'=>array('*'),	
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

		 
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Get json
	 */
	public function actionGetJson()
	{	
		//取得最後一筆Task
		$lastId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		echo $this->getJson($lastId,false);
	}
	public function actionGetOfficeJson()
	{	
		//取得最後一筆Task
		$lastId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		echo $this->getJson($lastId,'行政單位');
	}
	public function actionGetTeachJson()
	{	
		//取得最後一筆Task
		$lastId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		echo $this->getJson($lastId,'教學單位');
	}

	/**
	 * 取得特定時間(Taskid)資料
	 */
	public function actionGetJsonByID($id)
	{
		if(floor($id) == $id)
		{
			//檢查ID是否存在
			if(Task::model()->exists('TaskID = :TaskID', array(":TaskID"=>$id)))
			{
				echo $this->getJson($id,false);
			}else
			{
				echo "error";
			}
		};
	}

	public function actionGetOfficeJsonByID($id)
	{
		//echo $id;
		if(floor($id) == $id)
		{
			//檢查ID是否存在
			if(Task::model()->exists('TaskID = :TaskID', array(":TaskID"=>$id)))
			{
				echo $this->getJson($id,'行政單位');
			}else
			{
				echo "error";
			}
		};
	}
	/**
	 * 取得特定時間(Taskid)資料
	 */
	public function actionGetTeachJsonByID($id)
	{
		if(floor($id) == $id)
		{
			//檢查ID是否存在
			if(Task::model()->exists('TaskID = :TaskID', array(":TaskID"=>$id)))
			{
				echo $this->getJson($id,'教學單位');
			}else
			{
				echo "error";
			}
		};
	}

	/**
	 * 取得群組的更詳細資料
	 */
	public function actionGetJsonDetailByID($id)
	{

		if(Yii::app()->session['TaskID']);
		{
			//檢查ID是否存在
			if(Group::model()->exists('groupid = :groupid', array(":groupid"=>$id)))
			{
				echo $this->getJsonDetail(Yii::app()->session['TaskID'],$id);
			}else
			{
				echo "error";
			}
		};
	}


	/**
	 * 產生總和的Json
	 */
	private function getJson($id,$type)
	{
			$sql="SELECT @rownum := @rownum+1 AS 'Rank', a.*
				FROM (
				SELECT 
							`group`.`groupid` AS 'id',
							`group`.`type`, 
							`group`.`name`, 
							SUM(`data`.`GoogleData`) AS 'Pages',
							SUM(`data`.`google_backlink`) AS 'google_backlink',
                    		AVG(`data`.`google_page_rank`) AS 'PR',
                    		SUM(`data`.`GooglePlusShares`)AS 'GooglePlusShares',
                    		SUM(`data`.`TwitterShares`)AS 'TwitterShares',
                    		SUM(`data`.`Facebook`)AS 'Facebook',
                    		SUM(`data`.`FB_share_count`) AS 'FB_share_count',
                    		SUM(`data`.`FB_like_count`) AS 'FB_like_count',
                    		SUM(`data`.`FB_commentsbox_count`)AS 'FB_commentsbox_count',
                    		SUM(`data`.`FB_click_count`)AS 'FB_click_count',
                    		SUM(`data`.`LinkedInShares`)AS 'LinkedInShares',
                    		SUM(`data`.`LinkedInShares`+`data`.`FB_share_count`+`data`.`TwitterShares`) AS 'social_media',
							SUM(`data`.`doc`+`data`.`docx`+`data`.`pdf`+`data`.`ppt`+`data`.`pptx`+`data`.`ps`+`data`.`eps`) AS 'files'
							FROM
							`data` JOIN `site_url` ON `data`.`SiteID` = `site_url`.`SiteID` 
							JOIN `group` ON `site_url`.`groupid` = `group`.`groupid` 

							WHERE TaskID=".$id." ".($type!= false ? "and `group`.`type` ='$type'":"")."
							GROUP BY `group`.`groupid`

							ORDER BY  google_backlink  DESC,Pages  DESC,google_backlink DESC) a , (SELECT @rownum := 0) r;  ";	
			 

			$connection=Yii::app()->db;  
			$command=$connection->createCommand($sql);
			$rows=$command->queryAll();   

			//形態轉換，將需要成為數字的轉成正確的數字
			$rows2=array();
			foreach($rows as $value){

				$new_value=array(
					'id'=>$value['id'],

					'Rank'=>intval($value['Rank']),
					'Pages'=>intval($value['Pages']),
					'PR'=>intval($value['PR']),
					'google_backlink'=>intval($value['google_backlink']),
					'files'=>intval($value['files']),
					'name'=>$value['name'],
					'type'=>$value['type'],
					'social_media'=>intval($value['social_media']),
					);
				array_push($rows2,$new_value);
			}
			Yii::app()->session['TaskID'] = $id;
			return CJSON::encode($rows2);
	}
	/**
	 * 取得特定組織底下查詢資料的Json
	 */	
	private function getJsonDetail($TaskID,$groupid)
	{
		
			$sql="SELECT @rownum := @rownum+1 AS 'Rank', a.*
				FROM (
				SELECT 

							`site_url`.`name`, 
							`site_url`.`site`,
							`site_url`.`siteID`,
							(`data`.`alexa_rank`) AS 'alexa_rank',
                    		(`data`.`alexa_rank_tw`) AS 'alexa_rank_tw',
                    	    (`data`.`alexa_link`) AS 'alexa_link',
							(`data`.`GoogleData`) AS 'Pages',
							(`data`.`google_backlink`) AS 'google_backlink',
                    		(`data`.`google_page_rank`) AS 'PR',
                    		`data`.`GooglePlusShares`,
                    		`data`.`TwitterShares`,
                    		`data`.`Facebook`,
                    		`data`.`FB_share_count`,
                    		`data`.`FB_like_count`,
                    		`data`.`FB_commentsbox_count`,
                    		`data`.`FB_click_count`,
                    		`data`.`LinkedInShares`,
                    		(`data`.`doc`+`data`.`docx`) AS Word,
                    		`data`.`pdf`,
                    		(`data`.`ppt`+`data`.`pptx`) AS PPT,
                    		SUM(`data`.`doc`+`data`.`docx`+`data`.`pdf`+`data`.`ppt`+`data`.`pptx`+`data`.`ps`+`data`.`eps`) AS 'files'


							FROM
							`data` JOIN `site_url` ON `data`.`SiteID` = `site_url`.`SiteID` 

							WHERE TaskID=".$TaskID." and `site_url`.`groupid`=".$groupid."

							ORDER BY  PR  DESC,Pages  DESC,google_backlink DESC) a , (SELECT @rownum := 0) r ";	
			 

			$connection=Yii::app()->db;  
			$command=$connection->createCommand($sql);
			$rows=$command->queryAll();   

			//形態轉換，將需要成為數字的轉成正確的數字
			$rows2=array();

			//print_r($sql);
			foreach($rows as $value){

				$new_value=array(
					//'id'=>$value['id'],
					//附加連結
					'name'=>'<a href="' . $value['site'] .'" target="_blank">'.$value['name'].'</a>',

					'site'=>$value['site'],


					'Rank'=>intval($value['Rank']),
					'Pages'=>intval($value['Pages']),
					'alexa_rank'=>intval($value['alexa_rank']),
					'alexa_rank_tw'=>intval($value['alexa_rank_tw']),
					'alexa_link'=>intval($value['alexa_link']),
					'PR'=>intval($value['PR']),
					'google_backlink'=>intval($value['google_backlink']),
					'GooglePlusShares'=>intval($value['GooglePlusShares']),
					'TwitterShares'=>intval($value['TwitterShares']),
					'Facebook'=>intval($value['Facebook']),
					'FB_share_count'=>intval($value['FB_share_count']),
					'FB_like_count'=>intval($value['FB_like_count']),
					'FB_commentsbox_count'=>intval($value['FB_commentsbox_count']),
					'FB_like_count'=>intval($value['FB_like_count']),
					'LinkedInShares'=>intval($value['LinkedInShares']),
					'Word'=>intval($value['Word']),
					'PDF'=>intval($value['pdf']),
					'PPT'=>intval($value['PPT']),
					'files'=>intval($value['files']),
					'detail'=> '<a href="排名/Detail/' . $value['siteID'] .'" target="_blank">開啓視窗</a>',

					//'type'=>$value['type'],
					);
				array_push($rows2,$new_value);
			}
			return CJSON::encode($rows2);
	}	
	/**
	 * Lists all models.
	 */
	public function actionRankOffice()
	{

			$this->layout='//layouts/main';
			Yii::app()->clientScript->registerCoreScript('jquery');
			$this->render('index',array(
			'type'=>'行政單位',
			'json_route'=>'GetOfficeJson',
			));


	}
	public function actionRankTeach()
	{

			$this->layout='//layouts/main';
			Yii::app()->clientScript->registerCoreScript('jquery');
			$this->render('index',array(
			'type'=>'教學單位',
			'json_route'=>'GetTeachJson',
			));


	}

	public function actionIndex()
	{
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Data('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Data']))
			$model->attributes=$_GET['Data'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Data the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Data::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Data $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='data-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionDetail($id)
	{
		$this->layout='//layouts/main';
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/themes/bootstrap/js/waypoints.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/themes/bootstrap/js/jquery.counterup.min.js');
		//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/themes/bootstrap/js/circles.js');

		Yii::app()->getClientScript()->registerCss('Detail','
			.counters span {
		    	font-size: 35px;
		    	color: #FFBF00;
		    	text-align: center;
			}');
		$site_model=SiteUrl::model()->findByPk($id);

		if($site_model==null)
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		$group_model=Group::model()->findByPk($site_model->groupid);
		
		$lastTaskId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		$DataID = Yii::app()->db->createCommand('SELECT DataID FROM data WHERE `TaskID`='.$lastTaskId.' AND SiteID='.$id.' ORDER BY DataID DESC LIMIT 1')->queryScalar();


		$this->render('detail',array(
			'site_model'=>$site_model,
			'group_model'=>$group_model,
			'data'=> $this -> loadModel($DataID),
		));
	

	}
	public function actionGetJsonHistory($id)
	{
					$sql="SELECT 

					`GoogleData`,
					`google_page_rank`,
					`google_backlink`,
					`GooglePlusShares`,
					`PDF`,
					`TwitterShares`,
					`FB_share_count`,
					`FB_like_count`,
					`LinkedInShares`,
					`Time` 

					FROM data 

					WHERE siteID=".$id ." 

					ORDER BY DataID ASC ";	
					 

					$connection=Yii::app()->db;  
					$command=$connection->createCommand($sql);
					$rows=$command->queryAll();   

					//形態轉換，將需要成為數字的轉成正確的數字
					$rows2=array();

					//print_r($sql);
					foreach($rows as $value){

						$new_value=array(
							//'id'=>$value['id'],
							//附加連結
							'google_page_rank'=>intval($value['google_page_rank']),
							'google_backlink'=>intval($value['google_backlink']),
							'GooglePlusShares'=>intval($value['GooglePlusShares']),
							'TwitterShares'=>intval($value['TwitterShares']),
							'FB_share_count'=>intval($value['FB_share_count']),
							'FB_like_count'=>intval($value['FB_like_count']),
							'LinkedInShares'=>intval($value['LinkedInShares']),
							
							'time'=>$value['Time'],

							//'type'=>$value['type'],
							);
						array_push($rows2,$new_value);
					}
					echo CJSON::encode($rows2);
	}
}
