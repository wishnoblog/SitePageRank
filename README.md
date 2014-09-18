SitePageRank
============

學校網站在搜尋引擎的排名資料搜集，用於觀測記錄Google搜尋到的頁面數排名。

* 主要功能 *
取得Google對某個網域搜尋的結果數量。
多個網域對應到同一個組織。
同個組織內的網域內資料合併計算。

* 相關套件 *
Bootstrap 3.2
Yii 1.15

* 安裝環境 *
PHP 5.2+ (目前開發測試環境為PHP 5.3)
MySQL 5.5
php-curl模組
Apache-Rewrite(非必要)

* 安裝設定
網站Root頁面主要是SitePageRank資料夾
|-framework（yii套件庫）
|-SitePageRank
|--assets（請設定為777,此為網站Cached的目錄）
|--protected
|----config
|------config.php(網站相關設定)

** 設定檔
`\SitePageRank\protects\config\config.php`
