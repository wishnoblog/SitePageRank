<?php

class RunController extends Controller
{
	
	/**
	 * 手動執行
	 */
	public function actionIndex()
	{

		header('Content-Type: text/html; charset=utf-8');
		/**
		 * 輸入的流程應該是->產生GUID及時間碼->存入Task及變數->
		 */

		//$GUID = $this->GUID();
//		$timestamp= getTimestamp();

		$taskModel=new Task;
		$date = new DateTime();
		$taskModel->attributes = array
            (
            	'date'=> $date->format("Y-m-d H:i:s"),
            );
        $taskModel->save();
        $taskID=$taskModel->getPrimaryKey();

		$dataProvider = new CActiveDataProvider(
			SiteUrl::model(),
			array(
				'pagination' => false
				)
		);

		echo '資料庫共'.$dataProvider->totalItemCount.'筆資料'."\r\n";
		$i=0;
		foreach ($dataProvider->getData() as $record) {
            $site= $record -> site;
            $id = $record -> SiteID;

            //移除前面的http:// (若有的話)
            $site = preg_replace('#^https?://#', '', $site);
            $site = preg_replace('#^http?://#', '', $site);
            $results=$this->GetGoogleSearch('site:'.$site);
            //echo $site;

            //系統延遲
            sleep(2);
            $now = new DateTime;
            
            echo("[log]".$now->format( 'Y-m-d H:i:s' )."搜尋".$site."有".$results.'項結果 '."\r\n");

            $model = new Data;
            $model->attributes=array
            (
            	'SiteID'=>$id,
             	'GoogleData'=>$results,
             	'Time' => $now->format( 'U' ),
             	'YY'=>$now->format( 'Y' ),
             	'MM'=>$now->format( 'm' ),
             	'DD'=>$now->format( 'd' ),
             	'TaskID'=>$taskID
             	//'Time'=>$now->getTimestamp(),
            	);
            
            if($model->save())
            {
            	$i++;
            }else
            {
            	print_r($model->getErrors());	
            }

        }
		echo '執行完畢,共儲存'. $i .'筆資料';
		
		
		//$this->render('index');
	}
	/**
	 * 自動執行function
	 * 需要輸入$key驗證,用於執行Bash指令
	 */
	public function GetData($key)
	{
		header('Content-Type: text; charset=utf-8');
		if($key==Yii::app()->params['runKey'])
		{
			//執行

					$dataProvider=new CActiveDataProvider('SiteUrl');
					$i=0;
					echo '共'.$dataProvider->totalItemCount.'筆資料'."\r\n";
					foreach ($dataProvider->getData() as $record) {
			            $site= $record -> site;
			            $id = $record -> SiteID;

			            //移除前面的http:// (若有的話)
			            $site = preg_replace('#^https?://#', '', $site);
			            $site = preg_replace('#^http?://#', '', $site);
			            $results=$this->GetGoogleSearch('site:'.$site);
			            //echo $site;

			            //系統延遲
			            sleep(5);
			            $now   = new DateTime;
			            
			            echo("[log]".$now->format( 'Y-m-d H:i:s' )."搜尋".$site."有".$results.'項結果 '."\r\n");

			            $model=new Data;
			            $model->attributes=array
			            (
			            	'SiteID'=>$id,
			             	'GoogleData'=>$results,
			             	'YY'=>$now->format( 'Y' ),
			             	'MM'=>$now->format( 'm' ),
			             	'DD'=>$now->format( 'd' ),
			             	//'Time'=>$now->getTimestamp(),
			            	);
			            
			            if($model->save())
			            {
			            	$i++;
			            }else
			            {
			            	print_r($model->getErrors());	
			            }

			        }

		}else
		{
			//序號錯誤
			echo "驗證錯誤，請確認您的KEY正確";

		}

	}
	private function GetGoogleSearch($keyword)
	{

		require_once(Yii::app()->basePath . '/extensions/curl/GoogleWebSearch.php');
		//取資料
		$google_search = new GoogleWebSearch();
		$results = $google_search -> keyword_searchNumber($keyword);
		unset($google_search);
		return $results;

	}

	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}