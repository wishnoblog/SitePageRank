<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>提升網站於搜尋引擎排名(PageRank)</h1>

<p>提升排名與提升被快取的量有點雷同，但提升關鍵字排名主要是增加網站流量，讓網站內容容易被快取引擎排名上去。</p>

<h2>關鍵重點</h2>
<ul>
	<li>網站內容要放在正確的HTML Tag中，例如選單應該使用<code>li</code>呈現，表格不應該拿來排版，內文應該放在<code>div class="content"</code>標籤。</li>
	<li>網站容易被搜尋引擎讀取識別。</li>
	<li>網站頁面讀取速度快。(回應速度必須小於200ms)</li>
	<li>網站可讀性要高，使用者容易找到要的資訊，不會一進入就直接回到上一頁。</li>
	<li>觀察使用者行為，調整網站結構。</li>
	<li>檔名/網址與內文相符。</li>
	<li>使用標準的HTML呈現資料</li>
	<li>css/js檔案獨立成檔案</li>
</ul>

<ul>
	<li>重要內容、圖片不使用FLASH呈現，尤其是網站進入第一頁，Flash的內容不會被搜尋引擎解析。</li>
	<li>網址部分需要做管理，需要做好url Route，例如 <code>file/1-1-a.php</code> 整理成<code> /排行 </code></li>
	<li>加快網站回應速度(回應速度必須小於200ms)</li>
	<li>重要頁面以及鏈結不使用Ajax產生(Ex)，也不要使用Flash產生，用Ajax產生的頁面有很大機會搜尋引擎機器人會看不懂而略過索引。</li>
	<li>安裝Google Analistic 至網站所有頁面，分析使用者行為。</li>
	<li>提交SiteMap.xml，讓搜尋引擎可以正確快取網站資料。</li>
	<li>圖片及圖片鏈結加上Title標簽。</li>
	<li>使用Div Layout</li>
	<li>增加網站內容，例如專業領域專欄或專業訊息。</li>
	<li>買Google廣告</li>
	<li>內容上CDN</li>
</ul>
