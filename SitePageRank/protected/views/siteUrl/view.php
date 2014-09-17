<?php
/* @var $this SiteUrlController */
/* @var $model SiteUrl */

$this->breadcrumbs=array(
	'網址'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'列出網址', 'url'=>array('index'),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'新增', 'url'=>array('create'),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'更新', 'url'=>array('update', 'id'=>$model->SiteID),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'刪除', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->SiteID),'confirm'=>'Are you sure you want to delete this item?'),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'管理', 'url'=>array('admin'),'itemOptions' => array('class'=>'list-group-item'),),
);
?>

<h1>檢視網址 #<?php echo $model->SiteID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'SiteID',
		'name',
		array(
			  'name'=>'網址',
			  'type'=>'raw',			  
			  'value'=>CHtml::link($model->site ,
			  	 $model->site
				),
			  ),
		array(
			  'name'=>'網站分類',
			  'type'=>'raw',

			  'value'=>CHtml::link($model->siteType->name . 
			  	' (' . $model->siteType->type . ')',
			  	
			  	 array(
			  	 	'/group/' . $model->siteType->groupid )
			  	 ),
				),
		array(
			  'name'=>'網站分類',
			  'value'=>$model->siteType->type,
				),

		'Enable',
	),
)); ?>
