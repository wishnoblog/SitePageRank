<?php
/* @var $this SiteUrlController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'網址',
);

$this->menu=array(
	array('label'=>'新增網址', 'url'=>array('create'),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'管理網址', 'url'=>array('admin'),'itemOptions' => array('class'=>'list-group-item'),),
);
?>

<h1>網址</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>



