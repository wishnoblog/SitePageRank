<?php
/* @var $this DataController */

$this->pageTitle='排名 - '.Yii::app()->name;

?>

<h1><?php echo strpos(Yii::app()->request->url,'%E8%A1%8C%E6%94%BF')?'行政單位':'學術單位'; ?> 網站曝光程度排名 <small>網站資訊統計系統</small></h1>
<?php 
    //echo Yii::app()->request->requestUri;
	$data_url = Yii::app()->request->url . '/Getjson' ;
?>

<div class="row">
    <div class="col-md-3">
        

        <div class="form-group">
           <h3>統計時間選擇</h3>
           <?php 
               
                 $fa=Task::model()->findAll(array('order'=>'TaskID DESC', 'limit' => 10,));
                 //print(arg)
                 //public static array listData(array $models, string $valueField, string $textField, string $groupField='')
                 $ld=CHtml::listData($fa,'TaskID','date');
                 //print_r($ld); 
                 echo CHtml::DropDownList('TaskID','date',$ld,array('class'=>'form-control','onchange' => 'changeTaskID();',)); 
           ?>
           </div>
           <a href="<?php echo Yii::app()->request->url.'/report'; ?>" target="_blank" class="btn btn-primary">列印版</a>
           <div class="panel panel-info">
             <div class="panel-heading"><i class="fa fa-book"></i> 說明</div>
             <div class="panel-body">
               <ul>
                   <li> <i class="fa fa-line-chart"></i> 排名依照總分。</li>
                   <li>總分=Impacts*0.5＋Presence*0.17</li>
                   <li>
                       Presence指標，最新指標為檔案數量，統計<code>PDF/Word/Power Point/PS/EPS檔</code>。
                   </li>
                   <li>
                        Impacts指標，指的是其他網站連結至您網站的數量。
                   </li>
                
                   <li>
                       社群分享數目前統計FB、Twitter與Linkedit等分享或推薦數量，社群媒體分享情形大幅影響您網站訊息散播情形。
                   </li>
               </ul>
             </div>
           </div>

        </div>
    
    <div class="col-md-9">
        <div>
            <table id="table"  data-sort-order="asc"  data-height="299"  data-search="true">
                <thead>
                    <tr>
                        <th data-field="Rank" data-sortable="true" style="width : 30px;"><i class="fa fa-line-chart"> 排名</i></th>
                        <th data-field="name" data-align="center"  data-halign="center" style="width : 50px;"><i class="fa fa-flag"> 名稱</i></th>
                
                        <th data-field="type" data-align="center"  data-halign="center" data-sortable="true" style="width : 50px;"> <i class="fa fa-sitemap"></i> 類型</th>
                        <th data-field="score" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">總分</th>    
                        <th data-field="google_backlink" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Impacts(網站被連結量)50%</th>
                        <th data-field="files" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Presence指標(檔案數)17%</th>
                        <th data-field="social_media" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><i class="fa fa-share-alt"></i> 社群媒體</th>
                        
                      

                         
                    </tr>
                </thead>
            </table>
        </div>

        <div id='detail' style="margin-top:20px;">
            <table id="table-detail"  data-sort-order="asc">
                <thead>
                    <tr>
                        <th data-field="name"  style="width : 30px;"><i class="fa fa-flag"> 網站</i></th>

                        <th data-field="google_backlink" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google">被連結</th>
                        <th data-field="files" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">檔案數</th>
                         <th data-field="PDF" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><i class="fa fa-file-pdf-o"></i>PDF</th>
                         <th data-field="Word" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><i class="fa fa-file-word-o"></i>Word檔</th>
                        
                         <th data-field="PPT" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><i class="fa fa-file-powerpoint-o"></i>PPT檔</th>
                        <th data-field="Pages" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> 頁面量</i></th>
                       
                        <th data-field="FB_share_count" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-facebook.png" alt="facebook">分享</th>

                        <th data-field="TwitterShares" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-twitter.png" alt="Google"> Twiter</th>
                        <th data-field="LinkedInShares" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-linkedin.png" alt="linkdin"></i> linkedin</th>
                        <th data-field="detail" data-sortable="false"  data-align="right" data-halign="right" style="width : 50px;">詳細資料</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
  
</div>

<script type="text/javascript">
$( document ).ready(function() {
    //console.log( "ready!" );
    $('#table').bootstrapTable({
        url: "<?php echo $data_url ?>"
    });
    $('#detail').hide();


    $('#table').bootstrapTable({
    }).on('click-row.bs.table', function (e, row, $element) {
        //alert("click");
        //$result.text('Event: click-row.bs.table, data: ' + JSON.stringify(row));
        //alert(row['id']);
        var json = <?php echo '"' . Yii::app()->request->url . '/getJsonDetailbyid/"' ;?> + row['id'];
        $('#table-detail').bootstrapTable('destroy');
        $('#table-detail').bootstrapTable({
            url: json
        });
        $('#table-detail').bootstrapTable('load');
        $('#table-detail').bootstrapTable('refresh');
        $('#detail').show();

    });

});

function changeTaskID() {
    TaskID = $('#TaskID').val()
    //alert(TaskID);
    var json = <?php echo '"' . Yii::app()->request->url . '/Getjsonbyid/"' ;?> + TaskID;
    //alert(json);
    $('#table').bootstrapTable('destroy');
    $('#table').bootstrapTable({
        url: json
    });
    $('#table').bootstrapTable('load');
    $('#table').bootstrapTable('refresh');
    //$('#table').refresh();
    //alert("reflached");
} 
</script>
<script>

</script>