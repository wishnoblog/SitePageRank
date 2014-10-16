<?php
/* @var $this DataController */
/* @var $model Data */

?>
<h1><?php echo $site_model->name ?> <small><?php echo CHtml::link($site_model->site,$site_model->site, array('target'=>'_blank')); ?></small></h1>

<div class="row">
 <div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"> <i class="fa fa-link"></i>&nbsp; 被連結量(佔50%)</h3>
    </div>
    <div class="panel-body">
        <p class="text-center counters">被連結<span class="counter"><?php echo CHtml::encode($data->google_backlink) ?></span>次</p>
       <div class="span4 collapse-group">
        <div class="collapse"  id="viewdetails-backlink">
        <hr>         
            <h4>說明</h4>
          <p>連結數代表其他網頁超連結到您的網站的數量，數字越高代表越多網站連結到您的網站。</p>
          
           <h4>如何提高</h4>
          <ul>
            <li>建立高品質內容，並在頁面中加入分享的按鈕。</li>
            <li>經營社群媒體分享您網站的內容。</li>
          </ul>
     </div>
        <p><a class="btn btn-primary btn-sm pull-right" data-toggle="collapse" data-target="#viewdetails-backlink"><i class="fa fa-info fa-lg"></i>&nbsp; 說明</a></p>
      </div>
    </div>
  </div>
 <div class="panel panel-default">
   <div class="panel-heading">
     <h3 class="panel-title"><i class="fa fa-paperclip"></i> 檔案數(佔16.67%)</h3>
   </div>
   <div class="panel-body">
     <p class="text-center counters">提供<span class="counter"><?php echo CHtml::encode($data->pdf+$data->doc+$data->docx+$data->ppt+$data->pptx+$data->ps+$data->eps) ?></span>個檔案</p>
     <p>
     PDF:<span class="badge"><?php echo CHtml::encode($data->pdf) ?></span><br>
     Word:<span class="badge"><?php echo CHtml::encode($data->doc + $data->docx) ?></span><br>
     Power Point:<span class="badge"><?php echo CHtml::encode($data->ppt+$data->pptx) ?></span><br>
     PS/EPS:<span class="badge"><?php echo CHtml::encode($data->ps+$data->eps) ?></span><br>
     </p>
     <div class="span4 collapse-group">
     <div class="collapse"  id="viewdetails-files">
       <hr>
         <h4>如何提高</h4>
         <ul>
           <li>一份文件同時提供不同格式之檔案。</li>
           <li>網頁同時提供相同內容之附件。</li>
           <li>增加檔案及記錄上傳。</li>
         </ul>
          
         </div>

         <p><a class="btn btn-primary btn-sm pull-right" data-toggle="collapse" data-target="#viewdetails-files"><i class="fa fa-info fa-lg"></i>&nbsp; 說明</a></p>
      </div>
   </div>
 </div>

		


 </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comments"></i> 社群媒體經營</h3>
      </div>
      <div class="panel-body">
        <i class="fa fa-facebook-square fa-lg"></i>&nbsp; FaceBook分享數:<span class="badge"><?php echo CHtml::encode($data->FB_share_count) ?></span><br>
        <i class="fa fa-facebook-square fa-lg"></i>&nbsp; FaceBook按讚數:<span class="badge"><?php echo CHtml::encode($data->FB_like_count) ?></span><br>
        <i class="fa fa-twitter-square fa-lg"></i>&nbsp; Twitter分享數:<span class="badge"><?php echo CHtml::encode($data->TwitterShares) ?></span><br>
        <i class="fa fa-linkedin-square fa-lg"></i>&nbsp; LinkedIn分享數:<span class="badge"><?php echo CHtml::encode($data->LinkedInShares) ?></span><br>
      
      <hr>
      <div class="span4 collapse-group">
      <div class="collapse"  id="viewdetails-social_media">
      <h4>說明</h4>
      <p>
        社群媒體對於提高網站能見度相當重要，搜尋引擎會大量參考網站於社群媒體的狀態。
      </p>
      <h4>如何提高</h4>
      <p>
        提升網站易用性，好用有內容的頁面容易被使用者分享，
      </p>  
         </div>

         <p><a class="btn btn-primary btn-sm pull-right" data-toggle="collapse" data-target="#viewdetails-social_media"><i class="fa fa-info fa-lg"></i>&nbsp; 說明</a></p>
      </div>

      </div>
    </div>
  	<div class="panel panel-default">
  	  <div class="panel-heading">
  	    <h3 class="panel-title"><i class="fa fa-files-o"></i> 頁面數</h3>
  	  </div>
  	  <div class="panel-body">
		  <p class="text-center counters">網站約有<span class="counter"><?php echo CHtml::encode($data->GoogleData) ?></span>個頁面。</p>
		    <h4>說明</h4>
        <p>
  	    	網站頁面量，當然也有空內容重複被索引的，但這會讓搜尋引擎判定為垃圾內容網站。
  	    </p>
  	  </div>
  	</div>

  </div>		
  <div class="col-md-4">

	
  	<div class="panel panel-default">
  	  <div class="panel-heading">
  	    <h3 class="panel-title">網站資訊</h3>
  	  </div>
  	  <div class="panel-body">
  	    <p class="text-center">robot.txt:<?php echo ($data->robot)? ' <span class="label label-success"> 有 </span>':'<span class="label label-danger"> 無 </span>' ?> &nbsp; 
	      sitemap: <?php echo ($data->sitemap)? ' <span class="label label-success"> 有 </span>':'<span class="label label-danger"> 無 </span>' ?></p>
  	    <hr>
        <div class="span4 collapse-group">
        <div class="collapse"  id="viewdetails-info">

        <h4>說明</h4>
        <p>robot.txt是放在網站根目錄的一個檔案，目的在於指定哪些網頁目錄允許搜尋引擎索引，哪些目錄禁止搜尋引擎索引，提供此檔案可以大幅提高索引量。</p>
		    <p>sitemap.xml是放在網站根目錄的一個檔案，目的在於指定您網站頁面網址提供索引，以及這些目錄或頁面更新頻率，提供此檔案可以大幅提高網站被索引數量以及完整性</p>
        </div>

            <p><a class="btn btn-primary btn-sm pull-right" data-toggle="collapse" data-target="#viewdetails-info"><i class="fa fa-info fa-lg"></i>&nbsp; 說明</a></p>
         </div>

  	  </div>
  	</div>
  <div class="panel panel-default">
   <div class="panel-heading">
     <h3 class="panel-title">PageRank</h3>
   </div>
   <div class="panel-body">
    <div class="circle " id="circle-PR" style="text-align: center;"></div>
     <hr>
     <div class="span4 collapse-group">
     <div class="collapse"  id="viewdetails-pr">
       <h4 class="text-center">PageRank</h4>
       <p class="text-center">
       PageRank 0分~3分（差) <br>
       PageRank 4分~6分（普通)<br>
       PageRank 7分～9分以上（優)<br>
       </p>
       <p>
        <h4>說明</h4>
        PageRank是當時Google創辦人用於評分網頁重要性的計算方法，原始的計算方法是透過各網站連結至您網站的情形計算。
          <h4>如何提高</h4>
          <ul>
            <li>建立高品質及友善的網站，使人容易分享您的網站。</li>
            <li>網站針對搜尋引擎優化。</li>
            <li>讓其他重要網站設立鏈結至您的網站，以往常見的方式就是交換鏈結。</li>
           </ul> 
       </p>
          
     </div>

         <p><a class="btn btn-primary btn-sm pull-right" data-toggle="collapse" data-target="#viewdetails-pr"><i class="fa fa-info fa-lg"></i>&nbsp; 說明</a></p>
      </div>
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