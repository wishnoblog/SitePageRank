
<?php
/* @var $this ReportController */
$this->pageTitle='報表列印'.'-'.Yii::app()->name;
Yii::app()->clientScript->registerCoreScript('jquery');

?>
<h1>高應大網站曝光程度排名-<?php echo strpos(Yii::app()->request->url,'%E8%A1%8C%E6%94%BF')?'行政單位':'學術單位'; ?></h1>
<?php 
    //echo Yii::app()->request->requestUri;
	//這邊會直接取出使用者於上一個頁面選擇的日期
	$data_url = Yii::app()->request->url . '/Getjsonbyid/'.Yii::app()->session['TaskID'] ;
	$fa=Task::model()->findbypk(Yii::app()->session['TaskID']);

	$type="";
?>
<p>
	數據來源為Google自然搜尋結果。
	<ul>
		<li>Impacts(網站被連結）為外面網站頁面放置超連結至網站之數量</li>
		<li>Presence指標為搜尋引擎索引到的檔案數，統計PDF/Word/Power Point/PS/EPS檔。</li>
		<li>社群媒體為統計FB、Twitter、linkedin上連結數量。</li>
		<li>總分為 ( Impacts * 0.15 + Presence * 0.17) 之結果，再依照總分排序。</li>
	</ul>
	
</p>
<p class="pull-right">本次資料擷取時間為：<?php echo $fa->date; ?></p>
        <div>
            <table id="table"  data-sort-order="asc"  data-search="false">
                <thead>
                    <tr>
                        <th data-field="Rank" data-sortable="false" style="width : 30px;"><i class="fa fa-line-chart"> 排名</i></th>
                        <th data-field="name" data-align="center"  data-halign="center" style="width : 50px;"><i class="fa fa-flag"> 名稱</i></th>
                        <th data-field="score" data-sortable="false"  data-align="right" data-halign="right" style="width : 50px;">總分</th>    
                        <th data-field="google_backlink" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Impacts(網站被連結量)50%</th>
                        <th data-field="files" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Presence指標(檔案數)17%</th>
                        <th data-field="social_media" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><i class="fa fa-share-alt"></i> 社群媒體</th>                                                                  
                    </tr>
                </thead>
            </table>
        </div>
<?php 
    
      //$fa=Task::model()->findAll(array('order'=>'TaskID DESC', 'limit' => 10,));
      //print(arg)
      //public static array listData(array $models, string $valueField, string $textField, string $groupField='')
      //$ld=CHtml::listData($fa,'TaskID','date');
      //print_r($ld); 
      //echo CHtml::DropDownList('TaskID','date',$ld,array('class'=>'form-control','onchange' => 'changeTaskID();',)); 
?>
<script type="text/javascript">
$( document ).ready(function() {
    console.log( "ready!" );
    $('#table').bootstrapTable({
        url: "<?php echo $data_url ?>"
    });
});
</script>
</div>
