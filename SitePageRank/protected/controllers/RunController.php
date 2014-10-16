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
	public function actionGetData($key)
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
            if($googleIds==0)
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用重抓索引資料";
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
            if($googleLinks==0)
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用重抓反向鏈結資料";
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
			//site:pdf
			$pdf=$this->GetGoogleSearch("site:$site".' filetype:pdf');
            if($pdf==0)
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用重抓PDF鏈結資料";
            	$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:pdf');
            }

			usleep(rand(4000,10000));
			//doc
			$doc=$this->GetGoogleSearch("site:$site".' filetype:doc');
            if($doc==0)
            {	
            	//用另外種管道重抓一次
            	usleep(rand(5000,10000));
            	echo '[log]'.$site."使用重抓doc鏈結資料";
            	$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:doc');
            }
			usleep(rand(4000,10000));
			$docx=$this->GetGoogleSearch("site:$site".' filetype:docx');
			if($docx==0)
			{	
				//用另外種管道重抓一次
				usleep(rand(5000,10000));
				echo '[log]'.$site."使用重抓docx鏈結資料";
				$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:docx');
			}
			usleep(rand(4000,10000));
			//
			$ppt=$this->GetGoogleSearch("site:$site".' filetype:ppt');
			if($ppt==0)
			{	
				//用另外種管道重抓一次
				usleep(rand(5000,10000));
				echo '[log]'.$site."使用重抓ppt鏈結資料";
				$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:ppt');
			}
			usleep(rand(4000,10000));
			$pptx=$this->GetGoogleSearch("site:$site".' filetype:pptx');
			if($pptx==0)
			{	
				//用另外種管道重抓一次
				usleep(rand(5000,10000));
				echo '[log]'.$site."使用重抓pptx鏈結資料";
				$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:pptx');
			}
			usleep(rand(4000,10000));

			$ps=$this->GetGoogleSearch("site:$site".' filetype:ps');
			if($ps==0)
			{	
				//用另外種管道重抓一次
				usleep(rand(5000,10000));
				echo '[log]'.$site."使用重抓ps鏈結資料";
				$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:ps');
			}
			usleep(rand(4000,10000));
			$eps=$this->GetGoogleSearch("site:$site".' filetype:eps');
			if($eps==0)
			{	
				//用另外種管道重抓一次
				usleep(rand(5000,10000));
				echo '[log]'.$site."使用重抓EPS鏈結資料";
				$googleLinks=\SEOstats\Services\Google::getSiteindexTotal($site.' filetype:eps');
			}
			usleep(rand(4000,10000));


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
             	'pdf'=>$pdf,
             	'doc'=>$doc,
             	'docx'=>$docx,
             	'ppt'=>$ppt,
             	'pptx'=>$pptx,
             	'ps'=>$ps,
             	'eps'=>$eps,
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
            sleep(1);

            // if($i>3)
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