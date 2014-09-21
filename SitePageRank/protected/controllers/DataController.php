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
				'actions'=>array('index','view','GetJson','Rank'),
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
		$sql="SELECT 
			`group`.`groupid` AS 'id',
			`group`.`type`, 
			`group`.`name`, 
			 

			SUM(`data`.`GoogleData`) AS 'Pages',
			@curRank := @curRank + 1 AS Rank
			FROM

			`data` JOIN `site_url` ON `data`.`SiteID` = `site_url`.`SiteID` 
			JOIN `group` ON `site_url`.`groupid` = `group`.`groupid` 
			,(SELECT @curRank := 0) r 

			GROUP BY `group`.`groupid`

			ORDER BY  Pages desc";	
			 

			$connection=Yii::app()->db;  
			$command=$connection->createCommand($sql);
			$rows=$command->queryAll();   
			echo CJSON::encode($rows);

	}
	/**
	 * Lists all models.
	 */
	public function actionRank()
	{
			$this->layout='//layouts/main';
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
