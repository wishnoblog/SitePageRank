<?php
/* @var $this DataController */
/* @var $model Data */

$this->breadcrumbs=array(
	'Datas'=>array('index'),
	$model->DataID,
);

$this->menu=array(
	array('label'=>'List Data', 'url'=>array('index')),
	array('label'=>'Create Data', 'url'=>array('create')),
	array('label'=>'Update Data', 'url'=>array('update', 'id'=>$model->DataID)),
	array('label'=>'Delete Data', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->DataID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Data', 'url'=>array('admin')),
);
?>

<h1>View Data #<?php echo $model->DataID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'DataID',
		'SiteID',
		'GoogleData',
		'Time',
		'YY',
		'MM',
		'DD',
	),
)); ?>
