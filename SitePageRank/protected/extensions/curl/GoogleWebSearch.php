<?php
require_once ("HttpRequest.php");
require_once ("ResultItem.php");

/**
 * Google 搜尋結果
 * @author Yen Chia Wei < yenchiawei@gmail.com >
 */
 



class GoogleWebSearch {
	public function keyword_searchNumber($keyword) {
		//<div[^>]*?id="resultStats">約有 (.*?)項結果<nobr>
		

		// 從 Google 取得搜尋結果(HTML原始碼)
        $keyword = urlencode($keyword);
        $url = "https://www.google.com.tw/search?q={$keyword}&num=10";
        $httpReq = new HttpRequest();
        $httpReq -> setUrl($url);
        $content = $httpReq -> submit();
        unset($httpReq);
		//print_r($content);
        //var $results;
        //$pat;
        // 分析原始碼並取得每個項目
        preg_match('/<div id="resultStats">約有 (.*?)項結果<nobr>/' ,$content , $items); 
		if(!empty($items))
		{
			//print_r($items);
        	return str_replace(',',"",$items[1]);
    	}else
    	{
    		return '0';
    	}
	}
	//下面這段是原始作者提供的程式碼，用於解析Google搜尋後列出的項目，在本程式沒有使用。
    public function keyword_search($keyword) {
        
        // 從 Google 取得搜尋結果(HTML原始碼)
        $keyword = urlencode($keyword);
        $url = "https://www.google.com.tw/search?q={$keyword}&num=10";
        $httpReq = new HttpRequest();
        $httpReq -> setUrl($url);
        $content = $httpReq -> submit();
        unset($httpReq);
		
        $results = array();

        // 分析原始碼並取得每個項目
        if (preg_match_all('/<!--m-->(.*?)<!--n-->/s' , $content , $items)) {
            $idx = 0;
            foreach ( $items[1] as $key => $item ) {

                $resultItem = new ResultItem();
                $resultItem -> sequence = ($idx + 1);
                $resultItem -> title = preg_match('/<a .*?>(.*?)<\/a>/s' , $item , $res) ? trim($res[1]) : "";
                $resultItem -> link = urldecode(preg_match('/<h3 class="r"><a href="(.*?)".*?>.*?<\/a>/s' , $item , $res) ? trim($res[1]) : "");
                $resultItem -> description = preg_match('/<span class="st">(<span class="f">(.*?)<\/span>)?(.*?)<\/span>/s' , $item , $res) ? trim($res[3]) : "";
                $resultItem -> save_date = str_replace(" - " , "" , $res[2]);

                if(trim($resultItem -> link) == ""){
                    continue;
                }
                $idx ++;
                $results[] = $resultItem;
            }

        }

        return $results;
    }

}
?>