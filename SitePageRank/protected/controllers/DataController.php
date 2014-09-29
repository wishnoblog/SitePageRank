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
				'actions'=>array('index','view','GetJson','GetJsonByID','GetJsonDetailByID','Rank'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Data;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Data']))
		{
			$model->attributes=$_POST['Data'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->DataID));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Data']))
		{
			$model->attributes=$_POST['Data'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->DataID));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Get json
	 */
	public function actionGetJson()
	{	
		//取得最後一筆Task
		$lastId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		echo $this->getJson($lastId);



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
				echo $this->getJson($id);
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
	private function getJson($id)
	{
			$sql="SELECT @rownum := @rownum+1 AS 'Rank', a.*
				FROM (
				SELECT 
							`group`.`groupid` AS 'id',
							`group`.`type`, 
							`group`.`name`, 

							SUM(`data`.`alexa_rank`) AS 'alexa_rank',
                    		AVG(`data`.`alexa_rank_tw`) AS 'alexa_rank_tw',
                    		SUM(`data`.`alexa_link`) AS 'alexa_link',
							SUM(`data`.`GoogleData`) AS 'Pages',
							SUM(`data`.`google_backlink`) AS 'google_backlink',
                    		AVG(`data`.`google_page_rank`) AS 'PR'


							                   							FROM
							`data` JOIN `site_url` ON `data`.`SiteID` = `site_url`.`SiteID` 
							JOIN `group` ON `site_url`.`groupid` = `group`.`groupid` 

							WHERE TaskID=".$id."

							GROUP BY `group`.`groupid`

							ORDER BY  Pages desc ) a , (SELECT @rownum := 0) r;  ";	
			 

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
					'alexa_rank'=>intval($value['alexa_rank']),
					'alexa_rank_tw'=>intval($value['alexa_rank_tw']),
					'alexa_link'=>intval($value['alexa_link']),
					'PR'=>intval($value['PR']),
					'google_backlink'=>intval($value['google_backlink']),

					'name'=>$value['name'],
					'type'=>$value['type'],
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
							(`data`.`alexa_rank`) AS 'alexa_rank',
                    		(`data`.`alexa_rank_tw`) AS 'alexa_rank_tw',
                    	    (`data`.`alexa_link`) AS 'alexa_link',
							(`data`.`GoogleData`) AS 'Pages',
							(`data`.`google_backlink`) AS 'google_backlink',
                    		(`data`.`google_page_rank`) AS 'PR'


							FROM
							`data` JOIN `site_url` ON `data`.`SiteID` = `site_url`.`SiteID` 

							WHERE TaskID=".$TaskID." and `site_url`.`groupid`=".$groupid."


							ORDER BY  Pages desc ) a , (SELECT @rownum := 0) r ";	
			 

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
					'name'=>'<a href="' . $value['site'] .'" taget="_blank">'.$value['name'].'</a>',

					'site'=>$value['site'],


					'Rank'=>intval($value['Rank']),
					'Pages'=>intval($value['Pages']),
					'alexa_rank'=>intval($value['alexa_rank']),
					'alexa_rank_tw'=>intval($value['alexa_rank_tw']),
					'alexa_link'=>intval($value['alexa_link']),
					'PR'=>intval($value['PR']),
					'google_backlink'=>intval($value['google_backlink']),

										//'type'=>$value['type'],
					);
				array_push($rows2,$new_value);
			}
			return CJSON::encode($rows2);
	}	
	/**
	 * Lists all models.
	 */
	public function actionRank()
	{

			$this->layout='//layouts/main';
			Yii::app()->clientScript->registerCoreScript('jquery');
			$this->render('index');


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
}
