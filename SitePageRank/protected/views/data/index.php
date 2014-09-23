<?php
/* @var $this DataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'排名',
);

$this->menu=array(

);
?>

<h1>各單位及系所排名 <small>網站資訊統計系統</small></h1>
<?php 
	$data_url = Yii::app()->request->url . '/Getjson' ;
?>

<div class="row">
    <div class="col-md-3">
        

        <div class="form-group">
           <h3>時間調整</h3>
           <?php 
               
                 $fa=Task::model()->findAll(array('order'=>'TaskID DESC'));
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
                   <li>排名 <i class="fa fa-line-chart"></i> 欄位為依照Google Index數量排，被Index的頁面越多排序越高。</li>
                   <li>Google Index Statues <i class="fa fa-database"></i> 為Google索引您網站的數量，請參閱<a href="https://support.google.com/webmasters/answer/2642366?hl=en" target="_blank">說明</a></li>
               </ul>
             </div>
           </div>

        </div>
    
    <div class="col-md-9">
        <table id="table"  data-sort-order="asc"  data-search="true">
            <thead>
                <tr>
                    <th data-field="Rank" data-sortable="true" style="width : 30px;">排名 <i class="fa fa-line-chart"></i></th>
                    <th data-field="Pages" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Google Index Statues <i class="fa fa-database"></i></th>
                    <th data-field="type" data-align="center"  data-halign="center" data-sortable="true" style="width : 50px;">組織類型 <i class="fa fa-sitemap"></i></th>
                    <th data-field="name" data-align="center"  data-halign="center" style="width : 50px;">名稱 <i class="fa fa-flag"></i></th>
                    
                </tr>
            </thead>
        </table>
    </div>
  
</div>

<script type="text/javascript">
$( document ).ready(function() {
    //console.log( "ready!" );
    $('#table').bootstrapTable({
        url: "<?php echo $data_url ?>"
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
