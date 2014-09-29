<?php

class RunController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('GetData'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	/**
	 * 手動執行
	 */
	public function actionIndex()
	{

		header('Content-Type: text/html; charset=utf-8');

		$this->GetSEOState();

		//echo "連結數量".$this->get_rank_Alaxa_link('computer.kuas.edu.tw');

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
			$this->GetSEOState();
		}else
		{
			//序號錯誤
			echo "驗證錯誤，請確認您的KEY正確";

		}

	}
	/**
	 * 開始寫入資料
	 */
	private function GetSEOState()
	{
		/**
		 * 輸入的流程應該是->產生GUID及時間碼->存入Task及變數->
		 */
				require_once realpath(Yii::app()->basePath . '/extensions/SEOstats/bootstrap.php');


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
		            
		            

		            //系統延遲
		            sleep(2);
		            $now = new DateTime;
		            
		            $pagerank = \SEOstats\Services\Google::getPageRank($site);

		            //$results = \SEOstats\Services\Google::getSiteindexTotal('site:'.$site);
		            $googleIds=$this->GetGoogleSearch('site:'.$site);
		            sleep(2);
		            $googleLinks=$this->GetGoogleSearch('link:'.$site); 
		            echo("[log]".$now->format( 'Y-m-d H:i:s' )."搜尋".$site."有".$googleIds.'項結果 '."\r\n");

		            $model = new Data;
		            $model->attributes=array
		            (
		            	'SiteID'=>$id,
		             	'GoogleData'=>$googleIds,
		             	'google_backlink'=>$googleLinks,
		             	'Time' => $now->format( 'Y-m-d H:i:s' ),
		             	'YY'=>$now->format( 'Y' ),
		             	'MM'=>$now->format( 'm' ),
		             	'DD'=>$now->format( 'd' ),
		             	'TaskID'=>$taskID,
		             	'google_page_rank'=>$pagerank,
		             	'alexa_rank'=>$this->get_rank_Alaxa($site),
		             	'alexa_rank_tw'=>$this->get_rank_Alaxa_tw($site),
		             	'alexa_link'=>$this->get_rank_Alaxa_link($site),

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
	public function get_rank_Alaxa($url){
				
			$url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$url;
		  
			//Initialize the Curl  
			$ch = curl_init();  
			  
			//Set curl to return the data instead of printing it to the browser.  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2); 
			  
			//Set the URL  
			curl_setopt($ch, CURLOPT_URL, $url);  
			  
			//Execute the fetch  
			$data = curl_exec($ch);  
			  
			//Close the connection  
			curl_close($ch);  
			
			$xml = new SimpleXMLElement($data);  

	                //Get popularity node
			$popularity = $xml->xpath("//POPULARITY");

	                //Get the Rank attribute
			$rank = (string)$popularity[0]['TEXT']; 
			
			return $rank;
		}

		public function get_rank_Alaxa_tw($url){
					
				$url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$url;
			  
				//Initialize the Curl  
				$ch = curl_init();  
				  
				//Set curl to return the data instead of printing it to the browser.  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2); 
				  
				//Set the URL  
				curl_setopt($ch, CURLOPT_URL, $url);  
				  
				//Execute the fetch  
				$data = curl_exec($ch);  
				  
				//Close the connection  
				curl_close($ch);  
				
				$xml = new SimpleXMLElement($data);  

		                //Get popularity node
				$popularity = $xml->xpath("//COUNTRY");

		                //Get the Rank attribute
				$rank = (string)$popularity[0]['RANK']; 
				
				return $rank;
			}
			public function get_rank_Alaxa_link($url){
						
					$url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$url;
				  
					//Initialize the Curl  
					$ch = curl_init();  
					  
					//Set curl to return the data instead of printing it to the browser.  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2); 
					  
					//Set the URL  
					curl_setopt($ch, CURLOPT_URL, $url);  
					  
					//Execute the fetch  
					$data = curl_exec($ch);  
					  
					//Close the connection  
					curl_close($ch);  
					
					$xml = new SimpleXMLElement($data);  

			                //Get popularity node
					$popularity = $xml->xpath("//LINKSIN");

			                //Get the Rank attribute
					$rank = (string)$popularity[0]['NUM']; 
					
					return $rank;
				}
	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}