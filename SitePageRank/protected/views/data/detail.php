<?php
/* @var $this DataController */
/* @var $model Data */

?>
<h1><?php echo $site_model->name ?> <small><?php echo CHtml::link($site_model->site,$site_model->site, array('target'=>'_blank')); ?></small></h1>

<div class="row">
 <div class="col-md-4">
		<div class="circle " id="circle-PR" style="text-align: center;"></div>
		<h3 class="text-center">PageRank</h3>
		<p class="text-center">
		PageRank 3分以下（差) <br>
		PageRank 3分~5分以下（普通)<br>
		PageRank 6分以上（優)<br>
		</p>
 </div>
  <div class="counters col-md-4">

  	<div class="panel panel-default">
  	  <div class="panel-heading">
  	    <h3 class="panel-title">Google反向連結數(BackLinks)</h3>
  	  </div>
  	  <div class="panel-body">
  	  		<p class="text-center"><span class="counter"><?php echo CHtml::encode($data->google_backlink) ?></span>個頁面</p>
  	    	<p>反相連結數代表其他網頁超連結到您的網站的數量，數字越高代表越多網站連結到您的網站。</p>
  	  </div>
  	</div>

  	<div class="panel panel-default">
  	  <div class="panel-heading">
  	    <h3 class="panel-title">Google索引數(Google Page Indexes)</h3>
  	  </div>
  	  <div class="panel-body">
		<p class="text-center"><span class="counter"><?php echo CHtml::encode($data->GoogleData) ?></span>個頁面</p>
		<p>
  	    	數值越多，表示您的網站被Google索引的項目越多，您的頁面需要被索引到才會在使用者搜尋時顯示，但不代表您的項目容易被排在前面。
  	    </p>
  	  </div>
  	</div>

  </div>		
  <div class="col-md-4">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h3 class="panel-title">社群資訊</h3>
	    </div>
	    <div class="panel-body">
	      FaceBook分享數:<span class="badge"><?php echo CHtml::encode($data->FB_share_count) ?></span><br>
	      FaceBook按讚數:<span class="badge"><?php echo CHtml::encode($data->FB_like_count) ?></span><br>
	      Google+分享數:<span class="badge"><?php echo CHtml::encode($data->GooglePlusShares) ?></span><br>
	  	Twitter分享數:<span class="badge"><?php echo CHtml::encode($data->TwitterShares) ?></span><br>
	  	LinkedIn分享數:<span class="badge"><?php echo CHtml::encode($data->LinkedInShares) ?></span><br>
	  	
	    </div>
	  </div>
	
  	<div class="panel panel-default">
  	  <div class="panel-heading">
  	    <h3 class="panel-title">網站資訊</h3>
  	  </div>
  	  <div class="panel-body">
  	    <p class="text-center">robot.txt:<?php echo ($data->robot)? ' <span class="label label-success"> 有 </span>':'<span class="label label-danger"> 無 </span>' ?> </p>
	    <p class="text-center">sitemap: <?php echo ($data->sitemap)? ' <span class="label label-success"> 有 </span>':'<span class="label label-danger"> 無 </span>' ?></p>
  	    <p>robot.txt為一個檔案，目的在於指定哪些網頁目錄允許搜尋引擎索引，哪些目錄禁止搜尋引擎索引，提供此檔案可以大幅提高索引量。</p>
		<p>sitemap.xml為一個檔案，目的在於指定您網站頁面網址提供索引，以及這些目錄或頁面更新頻率，提供此檔案可以大幅提高網站被索引數量以及完整性</p>

  	  </div>
  	</div>

  </div>
<script src="/js/circles.js"></script>

<script>

        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 10,
                time: 1500
            });

        });
        Circles.create({
        	id:         'circle-PR',
        	percentage: <?php echo CHtml::encode($data->google_page_rank) ?>*10,
        	radius:     120,
        	width:      4,	
        	number:   	<?php echo CHtml::encode($data->google_page_rank) ?>,
        	text:       '分',
        	colors:     ['#D3B6C6', '#4B253A'],
        });

</script>