<?php

class HttpRequest {

    private $headers;

    private $isPost;

    private $isUpload;

    private $queries;

    private $url;

    private $timeout;

    private $userAgent;
    private $proxy;



    /**

     * 建構子：初始化所有變數

     */

    public function __construct() {

        $this -> headers = array();

        $this -> isPost = false;

        $this -> isUpload = false;

        $this -> queries = array();

        $this -> url = "";

        $this -> timeout = 30;

        $this -> proxy = false;
        $proxy=array(
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36 Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.10',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1944.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64; rv:28.0) Gecko/20100101 Firefox/28.0',
            'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:31.0) Gecko/20100101 Firefox/31.0',
            );
        $proxy=shuffle($proxy);
        $this -> userAgent = $proxy[0];

    }



    /**

     * 解構子：消除所有變數

     */

    public function __destruct() {

        unset($this -> headers);

        unset($this -> isPost);

        unset($this -> isUpload);

        unset($this -> queries);

        unset($this -> url);

        unset($this -> timeout);

        unset($this -> userAgent);

        unset($this -> proxy);

    }



    /**

     * 是否為上傳檔案的 Request

     */

    public function isUpload($upload = true) {

        $this -> isUpload = $upload;

    }



    /**

     * 是否為 POST

     */

    public function isPost($post = true) {

        $this -> isPost = $post;

    }



    /**

     * 設定表頭

     * @param string $header

     * @abstract

     * Connection: Keep-Alive

     * Content-type: application/x-www-form-urlencoded;charset=UTF-8

     */

    public function setHeader($header) {

        $this -> headers[] = $header;

    }



    /**

     * 設定 UserAgent

     * @param string $userAgent

     * @abstract

     * Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1

     */

    public function setUserAgent($userAgent) {

        $this -> userAgent = $userAgent;

    }



    /**

     * 設定要傳送的資料

     * @param string $name

     * @param string $value

     */

    public function setField($name , $value) {

        $this -> queries[$name] = $value;

    }



    /**

     * 超過多久時間自動斷線

     * @param integer $timeout

     */

    public function setTimeout($timeout) {

        $this -> timeout = $timeout;

    }



    /**

     * 設定網址

     * @param string $url

     */

    public function setUrl($url) {

        $this -> url = $url;

    }

    public function setProxy($proxy) {

        $this -> proxy = $proxy;

    }


    public function getSession($session = "") {



        $ch = curl_init();

        curl_setopt($ch , CURLOPT_URL , $this -> url);

        curl_setopt($ch , CURLOPT_NOBODY , false);

        curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);

        curl_setopt($ch , CURLOPT_HEADER , true);

        curl_setopt($ch , CURLOPT_FOLLOWLOCATION , false);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if($this -> proxy)
        {
            curl_setopt($ch, CURLOPT_PROXY, $this -> proxy);
        }


        curl_setopt($ch , CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1");

        if ($this -> headers != array()) {

            $options[CURLOPT_HTTPHEADER] = $this -> headers;

        }

        if ($session != "") {

            $options[CURLOPT_COOKIE] = $session;

        }



        $data = curl_exec($ch);

        curl_close($ch);



        preg_match_all('|Set-Cookie: (.*);|U' , $data , $results);



        return $results[1][count($results[1]) - 1];

    }



    /**

     * 送出

     * @param string $session = ""

     * @return string $response

     */

    public function submit($session = "") {

        // 未指定URL



        if (! $this -> url)

            return;



        $ch = $this -> create_curl($this -> url);

        $output = curl_exec($ch);

        echo curl_error($ch);

        curl_close($ch);

        unset($ch);



        return $output;

    }



    private function create_curl($url) {

        $ch = curl_init();



        $post_fields = ($this -> isUpload) ? $this -> queries : http_build_query($this -> queries);



        $this -> headers[] = "Cache-Control: no-cache";

        $this -> headers[] = "Pragma: no-cache";



        $options = array(

            CURLOPT_URL => $url ,

            CURLOPT_FOLLOWLOCATION => false ,

            CURLOPT_HEADER => false ,

            CURLOPT_RETURNTRANSFER => true ,

            CURLOPT_TIMEOUT => $this -> timeout ,

            CURLOPT_USERAGENT => $this -> userAgent ,

            CURLOPT_SSL_VERIFYPEER => false ,

            CURLOPT_SSL_VERIFYHOST => 0 ,

            CURLOPT_CAINFO => dirname(__FILE__) . "/cacert.pem"

        );



        if ($this -> isPost) {

            $options[CURLOPT_POST] = true;

            $options[CURLOPT_POSTFIELDS] = $post_fields;

        }



        if ($this -> headers != array()) {

            $options[CURLOPT_HTTPHEADER] = $this -> headers;

        }

        // if ($session != "") {

        //     $options[CURLOPT_COOKIE] = $session;

        // }



        curl_setopt_array($ch , $options);



        return $ch;

    }



    public function multi_submit($urls , $session = "") {



        $handles = array();



        $mh = curl_multi_init();



        $batch_count = 10;



        $batch_count = (count($urls) > $batch_count) ? $batch_count : count($urls);



        $pop_num = 0;



        file_put_contents("log/memory_usage.log" , memory_get_usage() . "\r\n" , FILE_APPEND | LOCK_EX);



        // 首批

        for ( $i = 0 ; $i < $batch_count ; $i++ ) {

            $ch = $this -> create_curl($urls[$pop_num]);

            $handles[] = array(

                "url" => $urls[$pop_num] ,

                "resource" => $ch ,

                "time" => 0 ,

                "content" => ""

            );

            $pop_num++;

            curl_multi_add_handle($mh , $ch);

        }



        file_put_contents("log/memory_usage.log" , memory_get_usage() . "\r\n" , FILE_APPEND | LOCK_EX);



        $active = 0;



        do {

            while ( ($mrc = curl_multi_exec($mh , $active)) == CURLM_CALL_MULTI_PERFORM );



            if ($mrc != CURLM_OK) {

                break;

            }



            while ( $done = curl_multi_info_read($mh) ) {

                $info = curl_getinfo($done['handle']);



                file_put_contents("log/memory_usage.log" , memory_get_usage() . "\r\n" , FILE_APPEND | LOCK_EX);



                if ($info['http_code'] == 200) {



                    $execute_time = $info["total_time"];



                    curl_multi_remove_handle($mh , $done['handle']);

                    if ($pop_num < count($urls)) {

                        $ch = $this -> create_curl($urls[$pop_num]);

                        $pop_num++;

                        curl_multi_add_handle($mh , $ch);

                    }

                }

            }



        } while($active);



        foreach ( $handles as $key => $handle ) {

            $content = curl_multi_getcontent($handle["resource"]);

            $content = (curl_errno($handle["resource"]) == 0) ? $content : "";

            $handle["content"] = $content;

            unset($handle["resource"]);

            $handles[$key] = $handle;

        }



        curl_multi_close($mh);



        file_put_contents("log/memory_usage.log" , memory_get_usage() . "\r\n" , FILE_APPEND | LOCK_EX);



        return $handles;

    }



}

?>