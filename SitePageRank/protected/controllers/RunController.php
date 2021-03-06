<?php
require_once realpath(Yii::app()->basePath . '/extensions/SEOstats/bootstrap.php');
use \SEOstats\Services\Social as Social;
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
				'actions'=>array('GetData','FixData'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','Fix'),
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
		echo("手動執行抓取");

		$this->GetNewSEOState();
		//echo "連結數量".$this->get_rank_Alaxa_link('computer.kuas.edu.tw');

	}
	/**
	 * 自動執行function
	 * 需要輸入$key驗證,用於執行Bash指令
	 */
	public function actionGetData($key)
	{
		header('Content-Type: text/html; charset=utf-8');
		if($key==Yii::app()->params['runKey'])
		{
			//執行
			$this->GetNewSEOState();
		}else
		{
			//序號錯誤
			echo "驗證錯誤，請確認您的KEY正確";

		}

	}
	public function actionFix()
	{
		header('Content-Type: text/html; charset=utf-8');
		
		echo "更新資料開始";
		$this->FixSEOState();
	}
	public function actionFixData()
	{
		header('Content-Type: text/html; charset=utf-8');
		if($key==Yii::app()->params['runKey'])
		{
			//執行
			echo "更新資料開始";
			$this->FixSEOState();
		}else
		{
			//序號錯誤
			echo "驗證失敗";

		}
	}	
	/**
	 * 開始寫入資料
	 */

	private function GetNewSEOState()
	{
		$taskModel=new Task;
		$date = new DateTime();
		$taskModel->attributes = array
            (
            	'date'=> $date->format("Y-m-d H:i:s"),
            );
        $taskModel->save();
        $taskID=$taskModel->getPrimaryKey();
        $this->GetSEOState($taskID);
	}

	/**
	 * 修正取得資料，僅修正最後一筆。
	 */
	private function FixSEOState()
	{
		//取得最後一筆Task
		$lastId = Yii::app()->db->createCommand('SELECT TaskID FROM task ORDER BY TaskID DESC LIMIT 1')->queryScalar();
		//取得網址
		$dataProvider = new CActiveDataProvider(
			SiteUrl::model(),
			array(
				'pagination' => false
				)
		);

		//echo '資料庫共'.$dataProvider->totalItemCount.'筆資料'."\r\n";
		$i=0;
		foreach ($dataProvider->getData() as $record) {
			//逐一將DataID取出
			//print_r($record);
			$DataId = Yii::app()->db->createCommand("SELECT DataId FROM data WHERE `SiteID`= $record->SiteID AND `TaskID` = $lastId LIMIT 1")->queryScalar();	
			//讀取資料
			$model=Data::model()->findByPk($DataId);

			if($model===null)
			{
				continue;
			}

			//print_r($model);
			//$model->getAttributes(array('name', 'distance'));
			//僅檢查Google API部分
			if($model->GoogleData=='0' or $model->GoogleData=='' or is_null($model->GoogleData) or empty($model->GoogleData))
			{
				usleep(rand(500,1000));
				$model->GoogleData=$this->GetGoogleSearch("site:$record->site");

				echo "[$record->site 修正索引部分],";

			}
			
			usleep(rand(1000,3000));
			if($model->google_backlink=='0' or $model->google_backlink=='' or is_null($model->google_backlink) or empty($model->google_backlink))
			{

				usleep(rand(500,1000));
				$model->google_backlink=$this->GetGoogleSearch("link:$record->site");
				echo "[$record->site 修正連結部分],";
			}

			//逐一檢查檔案是否取得資料。
			$fileTypeList=array(
				'pdf','doc','docx','ppt','pptx','ps','eps'
				);
			

			$fileCount=array();
			$error_statues=0;
			foreach ($fileTypeList as $key => $value) {
				usleep(rand(5000,10000));

				if($model->$value==0)
				{
					$model->$value=$this->GetGoogleSearch("site:$record->site".' filetype:'.$value);
					echo"[$record->site 修正檔案 $value 部分],";

					if(is_null($model->$value))
					{
						$model->$value=\SEOstats\Services\Google::getSiteFileTypeTotal($record->site,$value);
						
						//表示系統被Google封鎖了。
						if(is_null($model->$value))
						{
							$model->$value=0;
							$error_statues++;
						}

					}

				}
			}
			
			if($model->save())
			{
				$i++;
			}else
			{	print("網址: $site 出現錯誤");
				print_r($model->getErrors());	
			}
			usleep(rand(100,400));

		}

	Yii::app()->end();


	
		
	}//End Function
	
	/**
	 * 
	 */

	private function GetSEOState($taskID)
	{

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
            // if($i>=5)
            // {
            // 	break;
            // }
            //移除前面的http:// (若有的話)
            $site = preg_replace('#^https?://#', '', $site);
            $site = preg_replace('#^http?://#', '', $site);
            //系統延遲
            $pagerank=0;
            $now = new DateTime;
            try {
	            $pagerank = \SEOstats\Services\Google::getPageRank($site);
	            if(!is_numeric($pagerank))
	            {
	            	$pagerank=null;
	            }
            }catch (Exception $e) {
			    $pagerank=null;
			}

			usleep(rand(1000,3000));
            //下面這行是採用Google API提供之資料
            //$googleIds = \SEOstats\Services\Google::getSiteindexTotal($site);
            //下面這行是採用網頁搜尋結果資料
            
            if(($i % 2)==1)
            {
            	usleep(rand(500,1000));
            	$googleIds=$this->GetGoogleSearch("site:$site");
            	
            }else
            {
            	$googleIds=$this->GetGoogleSearch("site:$site");
            }
            sleep(3);
            if(is_null($googleIds))
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用重抓索引資料;/r/n";
            	$googleIds = \SEOstats\Services\Google::getSiteindexTotal($site);

            }

            if(($i % 2)==1)
            {
            	usleep(rand(500,1000));
            	$googleLinks=$this->GetGoogleSearch("link:$site");
            }else
            {
            	$googleLinks=$this->GetGoogleSearch("link:$site");

            }
            //如果抓不到資料就換個管道
            if(is_null($googleLinks))
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用API重抓頁面數資料;/r/n";
            	$googleLinks=\SEOstats\Services\Google::getBacklinksTotal($site);

            }
            
            
            usleep(rand(1010,15020));
            //echo("[log]".$now->format( 'Y-m-d H:i:s' )."搜尋".$site."有".$googleLinks.'項結果 '."\r\n");

            //取得社群分享數據
            
            $seostats = new \SEOstats\SEOstats;
            $seostats->setUrl("http://$site");
			$fb=Social::getFacebookShares(); 
			//print_r($fb);
			usleep(rand(4000,10000));
			
			//
			//設定抓取的檔案類型
			//
			$fileTypeList=array(
				'pdf','doc','docx','ppt','pptx','ps','eps'
				);

			$fileCount=array();
			$error_statues=0;
			foreach ($fileTypeList as $key => $value) {
				usleep(rand(5000,10000));
				if($error_statues==0)
				{
					$fileCount[$value]=$this->GetGoogleSearch("site:$site".' filetype:'.$value);
				}
				if(is_null($fileCount[$value]))
				{
					$fileCount[$value]=\SEOstats\Services\Google::getSiteFileTypeTotal($site,$value);
					
					//表示系統被Google封鎖了。
					if(is_null($fileCount[$value]))
					{
						$fileCount[$value]=0;
						$error_statues++;
					}

				}
			}
			
			usleep(rand(4000,10000));

			//取得網站資訊，包含網站一些設定資訊。
			$info=$this->get_url_info($site);
            $model = new Data;
            $model->attributes=array
            (
            	'SiteID'=>$id,
             	'GoogleData'=>$googleIds,
             	'google_backlink'=>$googleLinks,
             	
             	'filetime'=>($info['filetime'] =! -1 ? date("Y-m-d H:i:s" , $info['filetime'] ) : null),
             	'robot'=> $this->remoteFileExists("$site/robots.txt"),
             	'sitemap'=> $this->remoteFileExists("$site/sitemap.xml"),
             	'Time' => $now->format( 'Y-m-d H:i:s' ),
             	//'GooglePlusShares'=>Social::getGooglePlusShares(),
             	'Facebook'=>$fb['total_count'],
             	'FB_share_count'=>$fb['share_count'],
             	'FB_like_count'=>$fb['like_count'],
             	'FB_comment_count'=>$fb['comment_count'],
             	'FB_commentsbox_count'=>$fb['commentsbox_count'],
             	'FB_click_count'=>$fb['click_count'],
             	'TwitterShares'=>Social::getTwitterShares(),
             	'LinkedInShares'=>Social::getLinkedInShares(),
             	'pdf'=>$fileCount['pdf'],
             	'doc'=>$fileCount['doc'],
             	'docx'=>$fileCount['docx'],
             	'ppt'=>$fileCount['ppt'],
             	'pptx'=>$fileCount['pptx'],
             	'ps'=>$fileCount['ps'],
             	'eps'=>$fileCount['eps'],
             	'YY'=>$now->format( 'Y' ),
             	'MM'=>$now->format( 'm' ),
             	'DD'=>$now->format( 'd' ),
             	'TaskID'=>$taskID,
             	'google_page_rank'=>$pagerank,

        	);

            //Yii::app()->end();
            if($model->save())
            {
            	$i++;
            }else
            {	print("網址: $site 出現錯誤");
            	print_r($model->getErrors());	
            }
            usleep(rand(100,400));

            // if($i==3)
            // {
            // 	break;
            // }

        }
		echo '執行完畢,共儲存'. $i .'筆資料';
	}
	private function GetGoogleSearch( $keyword , $proxy = false )
	{

		require_once(Yii::app()->basePath . '/extensions/curl/GoogleWebSearch.php');
		//取資料
		$google_search = new GoogleWebSearch();
		$results = $google_search -> keyword_searchNumber($keyword,$proxy);
		unset($google_search);
		return $results;

	}
	private function get_rank_Alaxa($url){
			
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

	private function get_rank_Alaxa_tw($url){
			
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
	/**
	 * 取得網頁最後更新時間
	 */
	private function get_url_info($url)
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_HEADER, true);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_FILETIME, true);

		$result = curl_exec($curl);
		// Get info
		$info = curl_getinfo($curl);
		curl_close($curl); 
		//print_r($info);
		return $info;
	}
	/**
	 * 確認檔案是否存在
	 */
	private function remoteFileExists($url){
		$curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_NOBODY, true);
	    $result = curl_exec($curl);
	    $ret = 0;
	    if ($result !== 0) {
	        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
	        if ($statusCode == 200) {
	            $ret = 1;   
	        }
	    }
	    curl_close($curl);
	    return $ret;
	}

	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}