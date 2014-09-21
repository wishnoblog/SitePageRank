<?php
/* @var $this DataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'排名',
);

$this->menu=array(

);
?>

<h1>最新排名</h1>
<?php 
	$data_url = Yii::app()->request->url . '/Getjson' ;
?>

<table data-toggle="table" data-url="<?php echo $data_url?>" data-height="299" data-sort-name="Rank" data-sort-order="asc">
    <thead>
        <tr>
            <th data-field="Rank" data-sortable="true" style="width : 30px;">排名 <i class="fa fa-line-chart"></i></th>
            <th data-field="Pages" data-sortable="true"  data-align="right" data-halign="right" style="width : 50px;">Google取得頁面數 <i class="fa fa-database"></i></th>
            <th data-field="type" data-align="center"  data-halign="center" data-sortable="true" style="width : 50px;">組織類型 <i class="fa fa-sitemap"></i></th>
            <th data-field="name" data-align="center"  data-halign="center" data-sortable="true" style="width : 50px;">名稱 <i class="fa fa-flag"></i></th>
            
        </tr>
    </thead>
</table>

