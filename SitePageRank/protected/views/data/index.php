<?php
/* @var $this DataController */

$this->pageTitle='排名 - '.Yii::app()->name;

?>

<h1>各單位及系所排名 <small>網站資訊統計系統</small></h1>
<?php 
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
           <div class="panel panel-info">
             <div class="panel-heading"><i class="fa fa-book"></i> 說明</div>
             <div class="panel-body">
               <ul>
                   <li> <i class="fa fa-line-chart"></i> 排名欄位為依據 <img src="../images/icon-google.png" alt="Google">頁面索引量，數據越高代表頁面數越多，請參閱
                            <a href="https://support.google.com/webmasters/answer/2642366?hl=en" target="_blank">說明</a>。
                        </li>
                   <li>
                        <img src="../images/icon-google.png" alt="Google">PR 為Google對每個網站的評分，請參閱<a href="http://zh.wikipedia.org/zh-tw/PageRank" target="_blank">說明</a>
                   </li>
                   <li>
                        <img src="../images/icon-google.png" alt="Google">反向連結 為Google取得的其他網站連結到您網站的數量</a>
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
                
                        <th data-field="Pages" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> 頁面索引量</i></th>
                        <th data-field="PR" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> PR</th>
                        <th data-field="google_backlink" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> 反向連結數</th>
                      

                         
                    </tr>
                </thead>
            </table>
        </div>

        <div id='detail' style="margin-top:20px;">
            <table id="table-detail"  data-sort-order="asc">
                <thead>
                    <tr>
                        <th data-field="name"  style="width : 30px;"><i class="fa fa-flag"> 網站</i></th>

                        <th data-field="Pages" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> 頁面索引</i></th>
                        <th data-field="PR" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> PR</th>
                        <th data-field="google_backlink" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-google.png" alt="Google"> 反向連結數</th>
                        <th data-field="FB_share_count" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-facebook.png" alt="facebook">分享數</th>
                        <th data-field="LinkedInShares" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-linkedin.png" alt="linkdin"></i> linkedin</th>
                        <th data-field="GooglePlusShares" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;"><img src="../images/icon-googleplus.png" alt="G+"> Google+</th>

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