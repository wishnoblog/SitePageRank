SitePageRank
============

##目的
觀測記錄網址網站在搜尋引擎及SEO的相關指標資料搜集。

## 主要功能 

1. 取得Google對網址的相關資料。
1. 多個網址對應到同一個組織。
1. 同個組織內的網址資料合併計算。

##取得資料
2. Google PR
3. Google Index
4. Alexa Rank
5. Alexa Rank Taiwan
6. Alexa Rank

## 相關套件 
### 界面
Bootstrap 3.2  
Awesome font 4.2  
Yii 1.1.15  


## 安裝環境 
PHP 5.2+ (目前開發測試環境為PHP 5.3.x)  
MySQL 5.5  
php-curl模組  
Apache-Rewrite(非必要)  

## 安裝設定
網站Root頁面主要是SitePageRank資料夾

###資料夾權限
`SitePageRank\assets`（請設定為777,此為網站Cached的目錄）


### 設定檔 
`\SitePageRank\protects\config\config.php`  

### 如何批次執行

	wget http://localhost/index.php/cron/{key}

其中key要在下列檔案設定

	\SitePageRank\protects\config.php
	
	'params'=>array(
	...
	'runKey'=>'0OY6478Xl29695l649Ni',
	...
之後就可以使用wget直接執行PHP